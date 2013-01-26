Using Yampee Loader
===================

Basic usage
-----------------------

The Yampee Database library consists of a main class, `Yampee_Db_Manager`,
which is a factory of all the other classes. Thus you will only use `Yampee_Db_Manager`.

To create a instance of `Yampee_Db_Manager`, you need to know your database parameters.

You have to way to create an instance of your manager: using the DSN generator or not.

Using the DSN generator
=======================

The DSN generator build your DSN string based on the parameters you give ot it.
For instance, here, we create an instance of `Yampee_Db_Manager` for a MySQL
database called `test`, using user `root`.

``` php
<?php
$db = new Yampee_Db_Manager(new Yampee_Db_Dsn(Yampee_Db_Dsn::DRIVER_MYSQL, 'test'), 'root', '');
```

Using a classic DSN
===================

The DSN generator is completely optionnal:

``` php
<?php
$db = new Yampee_Db_Manager('mysql:host=localhost;dbname=test', 'root', '');
```

It is just a little bit more useful to use it.

Execute a query
-----------------------

To execute a query, it's very easy:

``` php
<?php
$results = $db->query('SELECT * FROM test');
```

Here, `$results` will contain a list of `Yampee_Db_Record` instances:

``` php
<?php
$results = $db->query('SELECT * FROM test');

foreach ($results as $result) {
	echo $result->getFirstField();
	echo $result->getDateField()->format('d/m/Y H:i');
}

// Or with parameters

$results = $db->query('SELECT * FROM test WHERE field = :test', array('test' => $value));

foreach ($results as $result) {
	echo $result->getFirstField();
	echo $result->getDateField()->format('d/m/Y H:i');
}
```

> **Note**: The `query()` method use prepared requests to avoid SQL injections.

> **Note**: The date fields are converted to DateTime objects on the fly.

The QueryBuilder
-----------------------

The most powerful feature of Yampee Database is probably the query builder. With it,
you can build your own query very easily:

``` php
<?php
$records = $db->createQueryBuilder()
	->select('t.field, t.otherField, ot.foreignField')
	->from('table t')
	->leftJoin('otherTable ot ON ot.table_id = t.id')
	->where('t.id = :id')
	->setParameter('id', 4)
	->limit(5)
	->execute();

$db->createQueryBuilder()
	->insert('table t')
	->set('t.firstField', $firstValue)
	->set('t.secondField', $secondValue)
	->execute();

$db->createQueryBuilder()
	->update('table t')
	->set('t.firstField', $firstValue)
	->set('t.secondField', $secondValue)
	->where('t.id = :id')
	->setParameter('id', 4)
	->execute();
```

The QueryBuilder is much more flexible than a simple query: you can use it in a loop, for instance.