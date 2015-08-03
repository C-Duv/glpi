<?php
/*
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2015 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/* Test for inc/db.function.php */


class DbFunctionTest extends PHPUnit_Framework_TestCase {

   protected function setUp() {
      global $CFG_GLPI;

      // Clean the cache
      unset($CFG_GLPI['glpiitemtypetables']);
      unset($CFG_GLPI['glpitablesitemtype']);

      // Pseudo plugin class for test
      require_once 'fixtures/pluginfoobar.php';
   }


   public function dataTableKey() {
      return array(
         array('foo', ''),
         array('glpi_computers', 'computers_id'),
         array('glpi_events', 'events_id'),
         array('glpi_users', 'users_id'),
         array('glpi_plugin_foo_bars', 'plugin_foo_bars_id'),
      );
   }


   /**
    * @covers getForeignKeyFieldForTable
    * @dataProvider dataTableKey
    */
   public function testGetForeignKeyFieldForTable($table, $key) {
      $this->assertEquals($key, getForeignKeyFieldForTable($table));
   }


   /**
    * @covers isForeignKeyField
    * @dataProvider dataTableKey
    *
    */
   public function testIsForeignKeyFieldBase($table, $key) {
      if ($key) {
         $this->assertTrue(isForeignKeyField($key));
      }
   }


   /**
    * @covers isForeignKeyField
    *
    */
   public function testIsForeignKeyFieldMore() {
      $this->assertFalse(isForeignKeyField('FakeId'));
      $this->assertFalse(isForeignKeyField('id_Another_Fake_Id'));
      $this->assertTrue(isForeignKeyField('users_id_tech'));
   }


   /**
    * @covers getTableNameForForeignKeyField
    * @dataProvider dataTableKey
    */
   public function testGetTableNameForForeignKeyField($table, $key) {
      if ($key) {
         $this->assertEquals($table, getTableNameForForeignKeyField($key));
      }
   }


   public function dataTableType() {
      return array(
         array('glpi_computers', 'Computer', true),
         array('glpi_users', 'User', true),
         array('glpi_events', 'Glpi\\Event', true),
         array('glpi_plugin_foo_bars', 'PluginFooBar', true),
         array('glpi_plugin_foo_bazs', 'PluginFooBaz', false),
      );
   }


   /**
    * @covers getTableForItemType
    * @dataProvider dataTableType
    */
   public function testGetTableForItemType($table, $type, $classexists) {
      $this->assertEquals($table, getTableForItemType($type));
   }


   /**
    * @covers getItemTypeForTable
    * @dataProvider dataTableType
    */
   public function testGetItemTypeForTable($table, $type, $classexists) {
      if ($classexists) {
         $this->assertEquals($type, getItemTypeForTable($table));
      } else {
         $this->assertEquals('UNKNOWN', getItemTypeForTable($table));
      }
   }


   /**
    * @covers getItemForItemtype
    * @dataProvider dataTableType
    */
   public function testGetItemForItemtype($table, $itemtype, $classexists) {
      if ($classexists) {
         $this->assertInstanceOf($itemtype, getItemForItemtype($itemtype));
      } else {
         $this->assertFalse(getItemForItemtype($itemtype));
      }
   }


   public function dataPlural() {
      return array(
         array('model', 'models'),
         array('address', 'addresses'),
         array('computer', 'computers'),
         array('thing', 'things'),
         array('criteria', 'criterias'),
         array('version', 'versions'),
         array('config', 'configs'),
         array('machine', 'machines'),
         array('memory', 'memories'),
         array('licence', 'licences'),
      );
   }


    /**
    * @covers getPlural
    * @dataProvider dataPlural
    */
   public function testGetPlural($singular, $plural) {
      $this->assertEquals($plural, getPlural($singular));
      $this->assertEquals($plural, getPlural(getPlural($singular)));
   }


   /**
    * @covers getSingular
    * @dataProvider dataPlural
    */
   public function testGetSingular($singular, $plural) {
      $this->assertEquals($singular, getSingular($plural));
      $this->assertEquals($singular, getSingular(getSingular($plural)));
   }


   /*
    * @covers countElementsInTable
    *
    */ /*  TO DO LATER
   public function testCountElementsInTable() {
   global $DB;
      //the case of using an element that is not a table is not handle in the function :
      //testCountElementsInTable($table, $condition="")
      toolbox::logdebug("Avant", $DB);
      $this->assertEquals(1, countElementsInTable('glpi_configs', "`name` = 'version'"));
      toolbox::logdebug("Entre");
      $this->assertGreaterThan(100, countElementsInTable('glpi_configs',"context = 'core'"));
      toolbox::logdebug("Apres");
   }
   
*/

/*
TODO :
countDistinctElementsInTable
countElementsInTableForMyEntities
countElementsInTableForEntity
getAllDatasFromTable
getTreeLeafValueName
getTreeValueCompleteName
getTreeValueName
getAncestorsOf
getTreeForItem
contructTreeFromList
contructListFromTree
getRealQueryForTreeItem
regenerateTreeCompleteName
 getNextItem
 getPreviousItem
 formatUserName
 getUserName
 TableExists
 FieldExists
 isIndex
 autoName
 closeDBConnections
*/
   /*
    * @covers formatOutputWebLink
    */
   public function testFormatOutputWebLink(){
      $this->assertEquals('http://www.glpi-project.org/',
                           formatOutputWebLink('www.glpi-project.org/'));
      $this->assertEquals('http://www.glpi-project.org/',
                           formatOutputWebLink('http://www.glpi-project.org/'));
   }

/*
TODO :
getDateRequest
exportArrayToDB
importArrayFromDB
get_hour_from_sql
getDbRelations
getEntitiesRestrictRequest
*/

}
