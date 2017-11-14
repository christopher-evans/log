# West PHP Log

A php logger supporting multiple log targets.


## Getting started

A new logger is constructed as follows:
 
```php
namespace West\Log;

// log format
$format = new ServerFormat(\DateTime::W3C, "\n");

// log levels
$logLevels = [
    'debug' => 0,
    'info' => 1,
    'notice' => 2,
    'warning' => 3,
    'error' => 4,
    'critical' => 5,
    'alert' => 6,
    'emergency' => 7
];

// log filter -- entries less than 'warning' are ignored
$filter = new MinLevelFilter($logLevels, 'warning');

// delimiters containing string parameters
$expansion = new StringExpansion('{', '}');

// write to a file
$target = new Target\File('test.log');

// add the file target to the log stack
$notifications = [
    new DefaultNotification(
        $target,
        $expansion,
        $format,
        $filter
    )
];

// create the log
$log = new AggregateLog($notifications);
```

Note that no validation is done on the log level, so it is up to the user to ensure a log level from a defined set is
passed to the `log` method.


## Changing the log format

A log entry is formatted by a `Format` instance passed to a notification. In particular different targets
may use different formats.

The `ServerFormat` class is the only implementation provided as an example in this package.


## Filtering log entries

A `Filter` can passed to each notification to determine which levels and time stamps are logged for a given target. The
`LevelFilter` class is provided as an example. With the `Log` constructed above:
 
```php
$log->log('emergency', 'This message will be added to the log');
$log->log('notice', 'This message will not be added to the log');
```

A `PipeFilter` is provided, which allows through all log entries.


## Serializing context parameters

An `Expansion` can be passed to each notification to serialize objects in the logged string. Using the `StringExpansion`
in the example above `$expansion = new StringExpansion('{', '}')` objects will be mapped to strings by casting. 
For example:

```php
$context = [
    'world' => 'WORLD'
];

// sends 'hello WORLD' to the log
$log->log('emergency', 'hello {world}', $context);
```

For templated log messages this allows for passing e.g. a string identifier for the template as the log message and
template variables for the context parameter.


## Adding log targets

The provides the `OutputStreamTarget` and `UdpTarget` log targets; other targets can be defined by the user.  This can
be any class implementing the `Target` interface.

A target receives a formatted and expanded string and adds add it to the log.


## Log Time

In all the examples above the log format received the current time before formatting.  A log entry can be added for any
specific time:

```php
$log->log('notice', 'hello world', [], new \DateTime('2000-01-01'));
```