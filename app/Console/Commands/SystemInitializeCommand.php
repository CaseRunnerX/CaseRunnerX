<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SystemInitializeCommand extends Command
{
    protected $signature = 'system:initialize';

    protected $description = 'Run this command for the first run to initialize system setting and other parameters';

    public function handle(): void
    {
        if($this->confirm('Are you sure you want to continue?', true))
        {
            // Generate Key
            $this->newLine(2);
            $this->info('Generating new System Key!');
            $this->call('generate:key');
            $this->info('✅ New System Key has been generated');
            // Generating Roles and Permissions
            $this->newLine(2);
            $this->info('Generating Roles and Permissions');
            try {

                $this->call('shield:generate', [
                    '--all'
                    ]);
                $this->info('✅ Roles and permission has been generated');
            }catch (\Exception $e)
            {
                $this->error('❌ Error during generating Roles and Permissions');
                $this->warn($e);
            }
            // Storage Link
            $this->newLine(2);
            $this->info('Creating symlink for the storage path');
            try {
                $this->call('storage:link');
                $this->info('✅ Storage path has been link to the public folder');
            }catch (\Exception $e)
            {
                $this->error('❌ Error during creating symlink for the storage path');
                $this->warn($e);
            }
            // Super Admin creation
            $this->newLine(2);
            $this->info('Creating Super Admin account');
            try {
                $this->call('shield:super-admin');
                $this->info('✅ Super Admin account has been created');
            }catch (\Exception $e)
            {
                $this->error('❌ Error during creation of super admin account');
                $this->warn($e);
            }

        }
    }
}
