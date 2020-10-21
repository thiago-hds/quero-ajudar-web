<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;

class ImportCsvFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv-files:import {vacancies_file_path} {applications_file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa aquivos csv com dados das vagas obtidas do site atados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {  
        $vacanciesFilePath = storage_path() . $this->argument('vacancies_file_path');
        $applicationsFilePath = storage_path() . $this->argument('applications_file_path');

        if(!file_exists($vacanciesFilePath)){
            echo sprintf("Arquivo %s não encontrado\n", $vacanciesFilePath);
            return -1;
        }

        if(!file_exists($applicationsFilePath)){
            echo sprintf("Arquivo %s não encontrado\n", $applicationsFilePath);
            return -1;
        }

        $faker = \Faker\Factory::create('pt_BR');

        $causesDict = [];
        $organizationsDict = [];
        $vacanciesDict = [];
        
        $vacanciesFile = fopen($vacanciesFilePath,'r');
        $count = 0;
        while (!feof($vacanciesFile)) {
            $vacancyData = fgetcsv($vacanciesFile, 0, ',');
            if($count > 0){
                $vacancy = new \App\Vacancy([
                    'name'                  => $vacancyData[2],
                    'description'           => $vacancyData[3] . ' ' . $vacancyData[4],
                    'tasks'                 => '',
                    'status'                => \App\Enums\StatusType::ACTIVE,
                    'type'                  => \App\Enums\RecurrenceType::RECURRENT,
                    'promotion_start_date'  => '01/10/2020',
                    'promotion_end_date'    => '31/12/2021',
                    'application_limit'     => 100,
                    'location_type'         => \App\Enums\LocationType::ORGANIZATION_ADDRESS
                ]);
                
                //organization
                if(!array_key_exists($vacancyData[21], $organizationsDict)){
                    
                    $formattedName = explode('/', $vacancyData[21])[2];

                    $organization = new \App\Organization([
                        'name'              => $vacancyData[20],
                        'website'           => sprintf('www.%s.com.br', $formattedName),
                        'description'       => $faker->paragraph($variableNbSentences = true),
                        'email'             => sprintf('contato@%s.com.br', $formattedName),
                        'status'            => \App\Enums\StatusType::ACTIVE
                    ]);

                    $organization->organizationType()->associate(3);
                    $organization->save();

                    $address = factory(\App\Address::class)->make();
                    $organization->address()->save($address);

                    $organization->phones()->save(new \App\Phone(['number' => '3199999999']));

                    $organizationsDict[$vacancyData[21]] = $organization->id;
                }

                $vacancy->organization()->associate($organizationsDict[$vacancyData[21]]);
                $vacancy->save();
                $vacanciesDict[$vacancyData[0]] = $vacancy->id;

                //causes
                $causes = explode('.', $vacancyData[5]);
                $vacancyCauses = [];
                foreach($causes as $value){
                    if(!array_key_exists($value, $causesDict)){
                        $cause = new \App\Cause([
                            'name' => $value
                        ]);
                        $cause->save();
                        
                        $causesDict[$cause->name] = $cause->id;
                    }

                    $vacancyCauses[] = $causesDict[$value];
                }
                $vacancy->causes()->sync($vacancyCauses);
                
                echo sprintf("Vacancy saved: %s \n",$vacancy->name);
            }
            $count += 1;
        }
        
        $volunteersDict = [];

        $applicationsFile = fopen($applicationsFilePath,'r');
        $count = 0;
        while (!feof($applicationsFile)) {
            $applicationData = fgetcsv($applicationsFile, 0, ',');
            if($count > 0){                
                //save volunteer
                if(!array_key_exists($applicationData[0], $volunteersDict)){
                    $user = new \App\User([
                        'first_name'        => $faker->firstName,
                        'last_name'         => $faker->lastName,
                        'date_of_birth'     => '01/01/1990',
                        'profile'           => \App\Enums\ProfileType::VOLUNTEER,
                        'email'             => $applicationData[0] . $faker->email,
                        'password'          => Hash::make(123123),
                        'status'            => \App\Enums\StatusType::ACTIVE
                    ]);
                    $user->save();
                    
                    $volunteer = new \App\Volunteer;
                    $volunteer->user()->associate($user);
                    $volunteer->save();

                    $volunteersDict[$applicationData[0]] = $user->id;
                }
                
                //save application
                $application = new \App\Application;
                $application->volunteer()->associate($volunteersDict[$applicationData[0]]);
                $application->vacancy()->associate($vacanciesDict[$applicationData[1]]);
                $application->save();

                echo sprintf("Application saved: %s %s , %s \n",
                    $user->first_name, $user->last_name, $applicationData[1]);
            }
            $count += 1;
        }
        
        return 0;
    }
}
