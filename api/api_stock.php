<?php

/* Check that the stock code*/
	function VerifyStockCode($StockCode, $i, $Errors, $db) {
		$Searchsql = "SELECT count(stockid) 
				FROM stockmaster
				WHERE stockid='".$StockCode."'";
		$SearchResult=DB_query($Searchsql, $db);
		$answer = DB_fetch_array($SearchResult);
		if ($answer[0]>0) {
			$Errors[$i] = StockCodeAlreadyExists;
		}
		return $Errors;
	}

/* Check that the stock code exists*/
	function VerifyStockCodeExists($StockCode, $i, $Errors, $db) {
		$Searchsql = "SELECT count(stockid) 
				FROM stockmaster
				WHERE stockid='".$StockCode."'";
		$SearchResult=DB_query($Searchsql, $db);
		$answer = DB_fetch_array($SearchResult);
		if ($answer[0]==0) {
			$Errors[$i] = StockCodeDoesntExist;
		}
		return $Errors;
	}

/* Verify the category exists */
	function VerifyStockCategoryExists($StockCategory, $i, $Errors, $db) {
		$Searchsql = "SELECT count(categoryid) 
				FROM stockcategory
				WHERE categoryid='".$StockCategory."'";
		$SearchResult=DB_query($Searchsql, $db);
		$answer = DB_fetch_array($SearchResult);
		if ($answer[0]==0) {
			$Errors[$i] = StockCategoryDoesntExist;
		}
		return $Errors;
	}

/* Check that the description is 50 characters or less long */		
	function VerifyStockDescription($StockDescription, $i, $Errors) {
		if (strlen($StockDescription)>50) {
			$Errors[$i] = IncorrectStockDescriptionLength;
		}
		return $Errors;
	}

/* Check that the long description is 256 characters or less long */		
	function VerifyStockLongDescription($StockLongDescription, $i, $Errors) {
		if (strlen($StockLongDescription)>256) {
			$Errors[$i] = IncorrectLongStockDescriptionLength;
		}
		return $Errors;
	}

/* Check that the units description is 20 characters or less long */		
	function VerifyUnits($units, $i, $Errors) {
		if (strlen($units)>20) {
			$Errors[$i] = IncorrectUnitsLength;
		}
		return $Errors;
	}
	
/* Check the mbflag has a valid value */
	function VerifyMBFlag($mbflag,$i, $Errors) {
		if ($mbflag!='M' and $mbflag!='K' and $mbflag!='A' and $mbflag!='B' and $mbflag!='D') {
			$Errors[$i] = IncorrectMBFlag;
		}
		return $Errors;
	}
	
/* Check that the last current cost date is a valid date. The date 
 * must be in the same format as the date format specified in the
 * target webERP company */
	function VerifyLastCurCostDate($CurCostDate, $i, $Errors, $db) {
		$sql='select confvalue from config where confname="'.DefaultDateFormat.'"';
		$result=DB_query($sql, $db);
		$myrow=DB_fetch_array($result);
		$DateFormat=$myrow[0];
		$DateArray=explode('/',$CurCostDate);
		if ($DateFormat=='d/m/Y') {
			$Day=$DateArray[0];
			$Month=$DateArray[1];
			$Year=$DateArray[2];
		}
		if ($DateFormat=='m/d/Y') {
			$Day=$DateArray[1];
			$Month=$DateArray[0];
			$Year=$DateArray[2];
		}
		if ($DateFormat=='Y/m/d') {
			$Day=$DateArray[2];
			$Month=$DateArray[1];
			$Year=$DateArray[0];
		}
		if (!checkdate(intval($Month), intval($Day), intval($Year))) {
			$Errors[$i] = InvalidCurCostDate;
		}
		return $Errors;
	}
	
/* Verify that the actual cost figure is numeric */	
	function VerifyActualCost($ActualCost, $i, $Errors) {
		if (!is_numeric($ActualCost)) {
			$Errors[$i] = InvalidActualCost;			
		}
		return $Errors;
	}
	
/* Verify that the last cost figure is numeric */	
	function VerifyLastCost($LastCost, $i, $Errors) {
		if (!is_numeric($LastCost)) {
			$Errors[$i] = InvalidLastCost;			
		}
		return $Errors;
	}
	
/* Verify that the material cost figure is numeric */	
	function VerifyMaterialCost($MaterialCost, $i, $Errors) {
		if (!is_numeric($MaterialCost)) {
			$Errors[$i] = InvalidMaterialCost;			
		}
		return $Errors;
	}
	
/* Verify that the labour cost figure is numeric */	
	function VerifyLabourCost($LabourCost, $i, $Errors) {
		if (!is_numeric($LabourCost)) {
			$Errors[$i] = InvalidLabourCost;			
		}
		return $Errors;
	}
	
/* Verify that the overhead cost figure is numeric */	
	function VerifyOverheadCost($OverheadCost, $i, $Errors) {
		if (!is_numeric($OverheadCost)) {
			$Errors[$i] = InvalidOverheadCost;			
		}
		return $Errors;
	}
	
/* Verify that the lowest level figure is numeric */	
	function VerifyLowestLevel($LowestLevel, $i, $Errors) {
		if (!is_numeric($LowestLevel)) {
			$Errors[$i] = InvalidLowestLevel;			
		}
		return $Errors;
	}
	
/* Verify that the Discontinued flag is a 1 or 0 */
	function VerifyDiscontinued($Discontinued, $i, $Errors) {
		if ($Discontinued!=0 and $Discontinued!=1) {
			$Errors[$i] = InvalidDiscontinued;			
		}
		return $Errors;
	}
	
/* Verify that the Controlled flag is a 1 or 0 */
	function VerifyControlled($Controlled, $i, $Errors) {
		if ($Controlled!=0 and $Controlled!=1) {
			$Errors[$i] = InvalidControlled;			
		}
		return $Errors;
	}
	
/* Verify that the eoq figure is numeric */	
	function VerifyEOQ($eoq, $i, $Errors) {
		if (!is_numeric($eoq)) {
			$Errors[$i] = InvalidEOQ;			
		}
		return $Errors;
	}
	
/* Verify that the volume figure is numeric */	
	function VerifyVolume($volume, $i, $Errors) {
		if (!is_numeric($volume)) {
			$Errors[$i] = InvalidVolume;			
		}
		return $Errors;
	}
	
/* Verify that the kgs figure is numeric */	
	function VerifyKgs($kgs, $i, $Errors) {
		if (!is_numeric($kgs)) {
			$Errors[$i] = InvalidKgs;			
		}
		return $Errors;
	}

/* Check that the barcode is 50 characters or less long */		
	function VerifyBarCode($barcode, $i, $Errors) {
		if (strlen($barcode)>50) {
			$Errors[$i] = IncorrectBarCodeLength;
		}
		return $Errors;
	}

/* Check that the discount category is 2 characters or less long */		
	function VerifyDiscountCategory($discountcategory, $i, $Errors) {
		if (strlen($discountcategory)>2) {
			$Errors[$i] = IncorrectDiscountCategory;
		}
		return $Errors;
	}

/* Check that the tax category exists*/
	function VerifyTaxCatExists($TaxCat, $i, $Errors, $db) {
		$Searchsql = "SELECT count(taxcatid) 
				FROM taxcategories
				WHERE taxcatid='".$TaxCat."'";
		$SearchResult=DB_query($Searchsql, $db);
		$answer = DB_fetch_array($SearchResult);
		if ($answer[0]==0) {
			$Errors[$i] = TaxCategoriesDoesntExist;
		}
		return $Errors;
	}
	
/* Verify that the Serialised flag is a 1 or 0 */
	function VerifySerialised($Serialised, $i, $Errors) {
		if ($Serialised!=0 and $Serialised!=1) {
			$Errors[$i] = InvalidSerialised;			
		}
		return $Errors;
	}

/* Check that the appendfile is 40 characters or less long */		
	function VerifyAppendFile($appendfile, $i, $Errors) {
		if (strlen($appendfile)>40) {
			$Errors[$i] = IncorrectAppendFile;
		}
		return $Errors;
	}
	
/* Verify that the Perishable flag is a 1 or 0 */
	function VerifyPerishable($Perishable, $i, $Errors) {
		if ($Perishable!=0 and $Perishable!=1) {
			$Errors[$i] = InvalidPerishable;			
		}
		return $Errors;
	}
	
/* Verify that the decimal places figure is numeric */	
	function VerifyDecimalPlaces($DecimalPlaces, $i, $Errors) {
		if (!is_numeric($DecimalPlaces)) {
			$Errors[$i] = InvalidDecmalPlaces;			
		}
		return $Errors;
	}

/* Insert a new stock item in the webERP database. This function takes an 
   associative array called $StockItemDetails, where the keys are the
   names of the fields in the stockmaster table, and the values are the 
   values to insert. The only mandatory fields are the stockid, description,
   long description, category, and tax category
   fields. If the other fields aren't set, then the database defaults
   are used. The function returns an array called $Errors. The database 
   is only updated if the $Errors is empty, else the function returns an 
   array of one to many error codes.
*/	
	function InsertStockItem($StockItemDetails, $user, $password) {
		$Errors = array();
		$db = db($user, $password);
		if (gettype($db)=='integer') {
			$Errors[0]=NoAuthorisation;
			return $Errors;
		}
		foreach ($StockItemDetails as $key => $value) {
			$StockItemDetails[$key] = DB_escape_string($value);
		}
		$Errors=VerifyStockCode($StockItemDetails['stockid'], sizeof($Errors), $Errors, $db);
		$Errors=VerifyStockDescription($StockItemDetails['decription'], sizeof($Errors), $Errors);
		$Errors=VerifyStockLongDescription($StockItemDetails['longdescription'], sizeof($Errors), $Errors);
		if (isset($StockItemDetails['categoryid'])){
			$Errors=VerifyStockCategoryExists($StockItemDetails['categoryid'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['units'])){
			$Errors=VerifyUnits($StockItemDetails['units'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['mbflag'])){
			$Errors=VerifyMBFlag($StockItemDetails['mbflag'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lastcurcostdate'])){
			$Errors=VerifyLastCurCostDate($StockItemDetails['lastcurcostdate'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['actualcost'])){
			$Errors=VerifyActualCost($StockItemDetails['actualcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lastcost'])){
			$Errors=VerifyLastCost($StockItemDetails['lastcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['materialcost'])){
			$Errors=VerifyMaterialCost($StockItemDetails['materialcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['labourcost'])){
			$Errors=VerifyLabourCost($StockItemDetails['labourcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['overheadcost'])){
			$Errors=VerifyOverheadCost($StockItemDetails['overheadcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lowestlevel'])){
			$Errors=VerifyLowestLevel($StockItemDetails['lowestlevel'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['discontinued'])){
			$Errors=VerifyDiscontinued($StockItemDetails['discontinued'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['controlled'])){
			$Errors=VerifyControlled($StockItemDetails['controlled'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['eoq'])){
			$Errors=VerifyEOQ($StockItemDetails['eoq'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['volume'])){
			$Errors=VerifyVolume($StockItemDetails['volume'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['kgs'])){
			$Errors=VerifyKgs($StockItemDetails['kgs'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['barcode'])){
			$Errors=VerifyBarCode($StockItemDetails['barcode'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['discountcategory'])){
			$Errors=VerifyDiscountCategory($StockItemDetails['discountcategory'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['taxcatid'])){
			$Errors=VerifyTaxCatExists($StockItemDetails['taxcatid'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['serialised'])){
			$Errors=VerifySerialised($StockItemDetails['serialised'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['appendfile'])){
			$Errors=VerifyApendFile($StockItemDetails['apendfile'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['perishable'])){
			$Errors=VerifyPerishable($StockItemDetails['perishable'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['decimalplaces'])){
			$Errors=VerifyDecimalPlaces($StockItemDetails['decimalplaces'], sizeof($Errors), $Errors);
		}
		$FieldNames='';
		$FieldValues='';
		foreach ($StockItemDetails as $key => $value) {
			$FieldNames.=$key.', ';
			$FieldValues.='"'.$value.'", ';
		}
		if (sizeof($Errors)==0) {
			$sql = 'INSERT INTO stockmaster ('.substr($FieldNames,0,-2).') '.
		  		'VALUES ('.substr($FieldValues,0,-2).') ';
			$result = DB_Query($sql, $db);
			$sql = "INSERT INTO locstock (loccode,stockid)
				SELECT locations.loccode,'" . $StockItemDetails['stockid'] . "'FROM locations";
			$result = DB_Query($sql, $db);			
			if (DB_error_no($db) != 0) {
				$Errors[0] = DatabaseUpdateFailed;
			} else {
				$Errors[0]=0;
			}
		}
		return $Errors;
	}

/* Update a stock item in the webERP database. This function takes an 
   associative array called $StockItemDetails, where the keys are the
   names of the fields in the stockmaster table, and the values are the 
   values to update. The only mandatory fields are the stockid, description,
   long description, category, and tax category
   fields. If the other fields aren't set, then the database defaults
   are used. The function returns an array called $Errors. The database 
   is only updated if the $Errors is empty, else the function returns an 
   array of one to many error codes.
*/	
	function ModifyStockItem($StockItemDetails, $user, $password) {
		$Errors = array();
		$db = db($user, $password);
		if (gettype($db)=='integer') {
			$Errors[0]=NoAuthorisation;
			return $Errors;
		}
		foreach ($StockItemDetails as $key => $value) {
			$StockItemDetails[$key] = DB_escape_string($value);
		}
		$Errors=VerifyStockCodeExists($StockItemDetails['stockid'], sizeof($Errors), $Errors, $db);
		if (in_array(StockCodeDoesntExist, $Errors)) {
			return $Errors;
		}
		if (isset($StockItemDetails['description'])){
			$Errors=VerifyStockDescription($StockItemDetails['decription'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['longdescription'])){
			$Errors=VerifyStockLongDescription($StockItemDetails['longdescription'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['categoryid'])){
			$Errors=VerifyStockCategoryExists($StockItemDetails['categoryid'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['units'])){
			$Errors=VerifyUnits($StockItemDetails['units'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['mbflag'])){
			$Errors=VerifyMBFlag($StockItemDetails['mbflag'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lastcurcostdate'])){
			$Errors=VerifyLastCurCostDate($StockItemDetails['lascurcostdate'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['actualcost'])){
			$Errors=VerifyActualCost($StockItemDetails['actualcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lastcost'])){
			$Errors=VerifyLastCost($StockItemDetails['lastcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['materialcost'])){
			$Errors=VerifyMaterialCost($StockItemDetails['materialcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['labourcost'])){
			$Errors=VerifyLabourCost($StockItemDetails['labourcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['overheadcost'])){
			$Errors=VerifyOverheadCost($StockItemDetails['overheadcost'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['lowestlevel'])){
			$Errors=VerifyLowestLevel($StockItemDetails['lowestlevel'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['discontinued'])){
			$Errors=VerifyDiscontinued($StockItemDetails['discontinued'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['controlled'])){
			$Errors=VerifyControlled($StockItemDetails['controlled'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['eoq'])){
			$Errors=VerifyEOQ($StockItemDetails['eoq'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['volume'])){
			$Errors=VerifyVolume($StockItemDetails['volume'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['kgs'])){
			$Errors=VerifyKgs($StockItemDetails['kgs'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['barcode'])){
			$Errors=VerifyBarCode($StockItemDetails['barcode'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['discountcategory'])){
			$Errors=VerifyDiscountCategory($StockItemDetails['discountcategory'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['taxcatid'])){
			$Errors=VerifyTaxCatExists($StockItemDetails['taxcatid'], sizeof($Errors), $Errors, $db);
		}
		if (isset($StockItemDetails['serialised'])){
			$Errors=VerifySerialised($StockItemDetails['serialised'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['appendfile'])){
			$Errors=VerifyApendFile($StockItemDetails['apendfile'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['perishable'])){
			$Errors=VerifyPerishable($StockItemDetails['perishable'], sizeof($Errors), $Errors);
		}
		if (isset($StockItemDetails['decimalplaces'])){
			$Errors=VerifyDecimalPlaces($StockItemDetails['decimalplaces'], sizeof($Errors), $Errors);
		}
		$sql='UPDATE stockmaster SET ';
		foreach ($StockItemDetails as $key => $value) {
			$sql .= $key.'="'.$value.'", ';
		}
		$sql = substr($sql,0,-2).' WHERE stockid="'.$StockItemDetails['stockid'].'"';
		if (sizeof($Errors)==0) {
			$result = DB_Query($sql, $db);
			echo DB_error_no($db);
			if (DB_error_no($db) != 0) {
				$Errors[0] = DatabaseUpdateFailed;
			} else {
				$Errors[0]=0;
			}
		}
		return $Errors;
	}

/* This function takes a stock code and returns an associative array containing
   the database record for that item. If the stock item number doesn't exist
   then it returns an $Errors array.
*/	
	function GetStockItem($StockID, $user, $password) {
		$Errors = array();
		$db = db($user, $password);
		if (gettype($db)=='integer') {
			$Errors[0]=NoAuthorisation;
			return $Errors;
		}
		$Errors = VerifyStockCodeExists($StockID, sizeof($Errors), $Errors, $db);
		if (sizeof($Errors)!=0) {
			return $Errors;
		}
		$sql='SELECT * FROM stockmaster WHERE stockid="'.$StockID.'"';
		$result = DB_Query($sql, $db);
		if (sizeof($Errors)==0) {
			return DB_fetch_array($result);
		} else {
			return $Errors;
		}
	}

/* This function takes a field name, and a string, and then returns an
   array of stockids that fulfill this criteria.
*/	
	function SearchStockItems($Field, $Criteria, $user, $password) {
		$Errors = array();
		$db = db($user, $password);
		if (gettype($db)=='integer') {
			$Errors[0]=NoAuthorisation;
			return $Errors;
		}
		$sql='SELECT stockid 
			FROM stockmaster 
			WHERE '.$Field.' LIKE "%'.$Criteria.'%"';
		$result = DB_Query($sql, $db);
		$i=0;
		$StockItemList = array();
		while ($myrow=DB_fetch_array($result)) {
			$StockItemList[$i]=$myrow[0];
			$i++;
		}
		return $StockItemList;
	}

	function GetStockbalance($StockID, $Location, $user, $password) {
		$Errors = array();
		$db = db($user, $password);
		if (gettype($db)=='integer') {
			$Errors[0]=NoAuthorisation;
			return $Errors;
		}
		$Errors = VerifyStockCodeExists($StockID, sizeof($Errors), $Errors, $db);
		if (sizeof($Errors)!=0) {
			return $Errors;
		}
		$sql='SELECT quantity FROM locstock WHERE stockid="'.$StockID.'" and loccode="'.$Location.'"';
		$result = DB_Query($sql, $db);
		if (sizeof($Errors)==0) {
			return DB_fetch_array($result);
		} else {
			return $Errors;
		}		
	}

?>