set :application, "banner"
set :domain,      "204.236.227.96"
set :deploy_to,   "/usr/share/nginx/webbanner"

# Deploy strategy
# set :deploy_via,      :rsync_with_remote_cache
set :user,        "webbanner"

set :app_path,    "app"

set :repository,  "git@github.com:mastop/webbanners.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, `subversion` or `none`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :keep_releases,  3

set  :use_sudo,      false

# Update vendors during the deploy
set :update_vendors,  true

set :dump_assetic_assets, true

# set :git_enable_submodules, 1

# Set some paths to be shared between versions
set :shared_files,    ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true
set :update_vendors, true
#namespace :deploy do
# desc "Atualiza vendors.sh"
#  task :vendorssh do
#   run("cd #{latest_release} && sh bin/vendors.sh")
#  end
#end
# after 'deploy:share_childs', 'deploy:vendorssh'