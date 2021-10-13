# QuickLogger PHP Class
QuickLogger is a simple logger class with text formatting for PHP.

## Usage
### Syntax
    class QuickLogger {
        /* Methods */
        public log(string $loggingLevel = <"OFF" | "FATAL" | "ERROR" | "WARN" | "INFO" | "DEBUG" | "TRACE" | "ALL">, 
            string $format [, ... $parameters]): void
        public error(string $format [, ... $parameters]): void
        public  warn(string $format [, ... $parameters]): void
        public  info(string $format [, ... $parameters]): void
        public debug(string $format [, ... $parameters]): void
        public __constructor(string $logFilename [, string $loggingLevel, boolean $hasDateTime]): void
    }

### Paramenters
**format**
- standard text formatting - example: https://www.php.net/manual/en/function.sprintf.php

**logFilename**
- Specifies the path and filename for where the logging will be done. If blank (''), it will log to standard & error output.

**hasDateTime**
- If the output should show timestamp or not. Default: true


## Examples
  - Declaration: 
    - This will write to a file
  
      `$log = new QuickLogger('/opt/log/application.log', 'INFO');`

    - This will write to the standard output

       `$log = new QuickLogger('', 'INFO');`

  - Usage:
 
        $log->info('Connection details: Host: %s, User: %s. Port: %d', $host, $user, $port);

        $log->error('Fatal error! Exiting...');
