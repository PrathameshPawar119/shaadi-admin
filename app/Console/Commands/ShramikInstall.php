<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ShramikInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shramik:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shramik install all';

    private bool $canRun = false;

    private array $bag = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('shramik Admin Installer');
        // waiting for 2 seconds
        $this->warn('shramik: Please wait...');
        sleep(2);

        $this->canRun();

        if ($this->canRun) {
            $this->warn("shramik: Preparation Complete...");
            $this->info("shramik: Starting...");

            $this->setAppKey();
            $this->migrateTable();
            $this->seedTable();
            // $this->createAdmin();
            $this->storageLink();

            // $this->resetCache();
            // $this->composerDumpAutoload();



            // waiting for 2 seconds
            $this->warn('shramik: Please wait...');
            sleep(2);
            $this->warn('shramik: Finishing Installation...');
            sleep(2);
            $this->info('-------------------------------');
            $this->info('Congratulations!');
            $this->info('The installation has been finished and you can now use ' . config('app.name'));
            $this->info( '*** to run backend --> php artisan serve ');
        }
        return 1;    }

    private function canRun()
    {
        if($this->confirm('shramik: Do you wish to proceed?', true)){
           $this->canRun = true; 
           $this->warn('shramik: Please wait...');

           sleep(2);
            if (App::version() > 9) {
                $this->bag[] = ['Framework', 'Pass [' . App::version() . ']', 'OK'];
            } else {
                $this->canRun = false;
                $this->bag[] = ['Framework', 'Fail', 'Minimum v.9 And Currently have :' . App::version()];
            }
            if (DB::connection()->getDatabaseName()) {
                $this->bag[] = ['Database', 'Active [' . DB::connection()->getDatabaseName() . ']', 'OK'];
            } else {
                $this->canRun = false;
                $this->bag[] = ['Database', 'InActive', 'Check Your DB Credentials'];
            }

            //Display Table
            $this->table(
                ['Attribute', 'Status', 'Recommendation'],
                $this->bag
            );

        } else {
            $this->error("shramik: Please Correct The App Version And Database Credentials for installation...");
        }
    }

    private function setAppKey()
    {
        $result = $this->call('key:generate');
        $this->info((string) $result);
    }

    private function migrateTable()
    {
        if($this->confirm('shramik: Do you wish to migrate:fresh ?', true)){
            sleep(2);
            $this->warn('shramik: Migrating all tables...');
            $migrate = $this->call('migrate:fresh');
            $this->info((string) $migrate);
        }
    }

    private function seedTable()
    {
        if($this->confirm('shramik: Do you wish to seed?', true)){
            sleep(2);
            $result = $this->call('db:seed');
            $this->info((string) $result);
        }
    }


    private function storageLink()
    {
        if ($this->confirm("shramik: Do You Wish To Symlink Storage Directory?", true)) {
            $this->warn('shramik: Please wait...');
            sleep(2);
            if (is_dir(public_path('storage'))) {
                rmdir(public_path('storage'));
            }

            $result = $this->call('storage:link');
            $this->info((string) $result);
        }
    }

    private function resetCache()
    {
        if ($this->confirm('shramik: Do You Wish To ReCache New Changes...?', true)) {
            sleep(2);
            // cached new changes
            $this->warn('shramik: Clearing cache...');
            $this->info('----------------------');
            $clear = $this->call('optimize:clear');
            $this->info((string) $clear);
            $this->newLine();
            $this->warn('shramik: Caching new changes...');
            $this->info('---------------------------');
            $optimize = $this->call('optimize');
            $this->info((string) $optimize);
        }
    }

    private function composerDumpAutoload()
    {
        if ($this->confirm("shramik: Do You Wish To Dump Composer For Auto loading Everything?", true)) {
            sleep(2);
            // running `composer dump-autoload`
            $this->warn('shramik: Composer Dump Autoload...');
            $result = shell_exec('composer dump-autoload');
            $this->info((string) $result);
        }
    }


}
