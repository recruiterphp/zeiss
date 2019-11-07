def run(*args)
  all_args = ['docker-compose', 'run', 'cli'] + args
  sh(all_args.join(' '))
end

task :build do
  sh 'docker-compose', 'build'
  sh 'docker-compose', 'start'
  run('composer', 'install')
end

task :composer, [:params] do |_, args|
  run('composer', args[:params])
end

task :test, [:params] do |_, args|
  run('vendor/bin/phpunit', String(args[:params]))
end

task :check do
  run('vendor/bin/phpstan', 'analyse', 'src', 'tests')
end

task :format do
  run('vendor/bin/php-cs-fixer', 'fix', '-v')
end
