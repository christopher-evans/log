# West\\Log

A PHP log implementation supporting multiple log targets.


## Getting started

A new logger is constructed as follows:
 
```php
namespace West\Log;

use Psr\Log\LogLevel;

// include vendor/autoload.php

$logFormat = new DefaultLogFormat('Y-m-d H:i:s', PHP_EOL);
$targets = [
    new Target\File(__DIR__ . '/example.log', $logFormat)
];

$log = new Log($targets);
$log->log(
    'emergency',
    'Here is a message with {context}',
    [
        'context' => 'context'
    ]
);
```

Note that no validation is done on the log level, so it is up to the user to ensure a log level from a defined set is
passed to the `log` method.


## Changing the log format

A log entry is formatted by a `LogFormatInterface` instance passed to the log target. In particular different targets
may use different formats.  The [PSR-3 specification](http://www.php-fig.org/psr/psr-3/) places restrictions on log
formatting that we adhere to in this package.

The `DefaultLogFormat` class is the only implementation provided in `West\Log`.


## Filtering log entries

A filter can passed to each target to determine which levels and time stamps are logged for a given target.  A filter
must implement `FilterInterface`.

The `MinLevelFilter` class is provided as an example, which will only log entries above a given severity for the usual
set of log levels: 'emergency', 'alert', 'critical', 'error', 'warning', 'info', 'notice', 'debug'.
 
```php
namespace West\Log;

use Psr\Log\LogLevel;

// include vendor/autoload.php

$logFormat = new DefaultLogFormat('Y-m-d H:i:s', PHP_EOL);
$filter = new MinLevelFilter('warning');
$targets = [
    new Target\File(__DIR__ . '/example.log', $logFormat, $filter)
];

$log->log('emergency', 'This message will be added to the log');
$log->log('notice', 'This message won\'t be added to the log');
```


## Adding log targets

`West\Log` provides the `Target\File` and `Target\Udp` log targets; other targets can be defined by the user.  This can
be any class implementing `Target\TargetInterface`.

The simplest way to add a new target is to extend `Target\AbstractTarget` with an implementation of the `logString`
method.  This method takes a pre-formatted string and should add this to the log.
 
 More complex behavior, such as filtering by data other than log level and time stamp of the log entry can be achieved
 by writing a `Target\TargetInterface` implementation that does not extend `Target\AbstractTarget`;
