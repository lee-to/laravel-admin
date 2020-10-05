<?php

namespace Leeto\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Leeto\Admin\Models\AdminUser;

class CreateUserCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:superuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the admin super user';


    public function handle()
    {
        $email = $this->ask("Email ?");
        $name = $this->ask("Name?");
        $password = $this->ask("Password?");

        if($email && $name && $password) {
            AdminUser::create(["email" => $email, "name" => $name, "password" => Hash::make($password)]);

            $this->info("User is created");
        } else {
            $this->error("All params is required");
        }
    }
}
