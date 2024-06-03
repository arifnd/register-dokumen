# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  # Which nixpkgs channel to use.
  channel = "stable-23.11"; # or "unstable"
  # Use https://search.nixos.org/packages to find packages
  packages = [
    pkgs.php82
    pkgs.php82Packages.composer
    pkgs.sqlite
  ];
  # Sets environment variables in the workspace
  env = {};
  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    extensions = [
      # "vscodevim.vim"
    ];
    # Enable previews
    previews = {
      enable = true;
      previews = {
        web = {
          command = ["php" "artisan" "serve" "--port" "$PORT" "--host" "0.0.0.0"];
          manager = "web";
        };
      };
    };
    # Workspace lifecycle hooks
    workspace = {
      # Runs when a workspace is first created
      onCreate = {
        composer-install = "composer install";
        copy-environment = "cp .env.example .env";
        generate-key = "php artisan key:generate";
        change-connection = "sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env";
        set-database = "sed -i \"s|DB_DATABASE=laravel|DB_DATABASE=$(pwd)/database/database.sqlite|\" .env";
        migrate-database = "php artisan migrate --seed --force";
      };
    };
  };
}