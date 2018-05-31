<?php

namespace Deployer;

require 'vendor/deployer/deployer/recipe/common.php';

// Project name
set('application', 'static.sportbooking.com');

// Project repository
set('repository', 'ssh://bitbucket.sportbooking.com/sb/static.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

set('shared_files', ['config/config.php', 'config/tokens.php']);
set('shared_dirs', ['files']);
set('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('deploy.test.sportbooking.com')
    ->configFile('~/.ssh/config')
    ->forwardAgent(true)
    ->set('deploy_path', '/srv/www/sportbooking.com/static');

set('composer_options', 'update --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');

task('deploy',
    [
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:shared',
        'deploy:writable',
        'deploy:vendors',
        'deploy:clear_paths',
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
        'success'
    ]
);

task('fast',
    [
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:shared',
        'deploy:writable',
        'deploy:clear_paths',
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
        'success'
    ]
);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
