After the project is downloaded locally, additional program dependencies for the Laravel project MUST be installed. Please run into your CLI:

    composer install
    
Create a copy from the .env.example file from the root folder of the project and name it .env Can be done it in the CLI with the command:

    cp .env.example .env

Generate an App Encryption Key:

    php artisan key:generate

This will create an app key string into the APP_KEY setting of the .env

Create empty database for the application.

Add the details for the database connection to the .env file (Host, database name, username and password)

Migrate the database with the following code in your CLI:

    php artisan migrate
    
This WILL generate the tables in the created database: users, boards and grades.

Please set the "public" folder from the project as a domain main point, or use the path to '/students/public' folder to start the application.
