# Tasks

Below is an overview of the available tasks in the [Taskfile](./Taskfile.yml):

### Code Formatting and Analysis

- **Pint**:

    - **_Command_**: `task pint`
    - **_Description_**: Runs Laravel Pint for code formatting according to [the defined configuration](./pint.json).

- **Rector**:

    - **_Command_**: `task rector`
    - **_Description_**: Executes Rector for automated code refactoring, ensuring modern coding practices according to [the defined configuration](./rector.php).

- **PHPStan Analysis**:

    - **_Commands_**:
        - `task phpstan:app` for [application code analysis](./phpstan.dist.neon).
        - `task phpstan:tests` for [test code analysis](./phpstan.tests.dist.neon).
        - `task phpstan` to run both.
    - **_Description_**: Performs static analysis of the code to detect potential issues and bugs.

- **Linting**:

    - **_Commands_**:
        - `task lint` for checking code style and potential issues.
        - `task lint:fix` to automatically fix any detected issues.
    - **_Description_**: Bundles the previous three tasks (Pint, Rector, PHPStan) for comprehensive code analysis and formatting.

### Testing

- **Unit Tests**:

    - **_Command_**: `task test:unit`
    - **_Description_**: Executes the unit tests, ensuring individual units of code work as expected.

- **Integration Tests**:

    - **_Command_**: `task test:integration`
    - **_Description_**: Runs the integration tests, verifying the interactions between different parts of the application.

- **All Tests**:

    - **_Command_**: `task test`
    - **_Description_**: Runs both unit and integration tests for complete coverage.

### Dependency Management and Laravel Commands

- **Manage Dependencies**:

    - **_Command_**: `task composer -- [COMPOSER_ARGS]`
    - **_Description_**: Executes composer command e.g. `task composer -- update`.

- **Install Dependencies**:

    - **_Command_**: `task install`
    - **_Description_**: Executes composer install to install all project dependencies.

- **Artisan Commands**:

    - **_Command_**: `task artisan`
    - **_Description_**: Provides access to Laravel Artisan commands for various application management tasks.

- **Tinker**:

    - **_Command_**: `task tinker`
    - **_Description_**: Launches the Laravel Tinker tool for interactive testing and debugging.

### Docker and Container Management

#### Docker Services Management:

- **Up/Down**:
    - **_Command_**: `task up`/`task down`
    - **_Description_**: Brings up/down Docker Compose services, managing the application's environment.
- **Database**:
    - **_Command_**: `task database`
    - **_Description_**: Specifically brings up the database service, allowing isolated control over the database environment.

#### Executing Commands in Docker Environment:

- **ExecRun**:
    - **_Command_**: `task execrun`
    - **_Description_**: Launches a command using the "exec task" if the Docker container is running, or with the "run task" otherwise. This task ensures commands are executed in the appropriate Docker environment, whether the container is already up or not.
- **Shell**:
    - **_Command_**: `task shell`
    - **_Description_**: Opens a shell in the container, providing a command-line interface for direct interaction with the containerized environment.


These tasks are designed to make the development process smoother and more efficient, allowing you to focus more on coding and less on managing various commands and tools.
