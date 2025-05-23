<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Settings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle(): void
    {
        $this->handleWebPermissions();
        $this->handleApiPermissions();
    }

    protected function handleWebPermissions(): void
    {
        $per = 0;
        $jsonFile = storage_path('configs/permissions.json');

        if (File::exists($jsonFile)) {
            $jsonContent = File::get($jsonFile);
            $permissions = json_decode($jsonContent, true);

            if (is_array($permissions)) {
                foreach ($permissions as $permission) {
                    if (!Permission::where('name', $permission['name'])->exists()) {
                        Permission::create($permission);
                        $per++;
                    }
                }
            }

            $per
                ? $this->info("Web permissions ({$per}) written! ✔️")
                : $this->info("Web permissions already exist! ✔️");
        } else {
            $this->error("permissions.json not found ❌");
        }
    }

    protected function handleApiPermissions(): void
    {
        $permissions = config('api_permissions');
        $count = 0;

        if (is_array($permissions)) {
            foreach ($permissions as $group => $items) {

                if (is_string($items)) {
                    if (!Permission::where('name', $items)->exists()) {
                        Permission::create(['name' => $items, 'guard_name' => 'api']);
                        $count++;
                    }
                    continue;
                }

                if (is_array($items)) {
                    foreach ($items as $key => $name) {
                        if (!Permission::where('name', $name)->exists()) {
                            Permission::create(['name' => $name, 'guard_name' => 'api']);
                            $count++;
                        }
                    }
                }
            }
        }

        $count
            ? $this->info("API permissions ({$count}) written! ✔️")
            : $this->info("API permissions already exist! ✔️");
    }
}
