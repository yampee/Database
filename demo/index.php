<?php

require '../autoloader.php';

$db = new Yampee_Db_Manager('mysql:host=localhost;dbname=test', 'root', '');

/*
 * Select
 */
$results = $db->query('SELECT * FROM tga_audience_sessions');

foreach ($results as $result) {
	echo $result->getFirstField();
	echo $result->getDateField()->format('d/m/Y H:i');
}

/*
 * Insert
 */
$record = new Yampee_Db_Record();
$record->setFirstField('127.0.0.1');
$record->setSecondField('127.0.0.1');
$record->setDateField(new DateTime());

$db->insert('table_name', $record);

/*
 * Query builder
 */
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