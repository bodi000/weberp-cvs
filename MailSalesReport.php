<?php
/* $Revision: 1.2 $ */
/*Now this is not secure so a malicious user could send multiple emails of the report to the intended receipients

The intention is that this script is called from cron at intervals defined with a command like:

/usr/bin/wget http://localhost/web-erp/MailSalesReport.php

The configuration of this script requires the id of the sales analysis report to send
and an array of the receipients */

The Sales report to send */
$ReportID = 4;

/*The people to receive the emailed report */
$Recipients = array('"Root" <root@localhost>','"some one else" <someoneelese@sowhere.com>');

include("config.php");
include("includes/ConnectDB.inc");

if (isset($SessionSavePath)){
	session_save_path($SessionSavePath);
}

session_start();



include ("includes/ConstructSQLForUserDefinedSalesReport.inc");
include ("includes/PDFSalesAnalysis.inc");

include('includes/htmlMimeMail.php');
$mail = new htmlMimeMail();

if ($Counter >0){ /* the number of lines of the sales report is more than 0  ie there is a report to send! */
	$pdfcode = $pdf->output();
	$fp = fopen( $reports_dir . "/SalesReport.pdf","wb");
	fwrite ($fp, $pdfcode);
	fclose ($fp);

	$attachment = $mail->getFile( $reports_dir . "/SalesReport.pdf");
	$mail->setText("Please find herewith sales report");
	$mail->SetSubject("Sales Analysis Report");
	$mail->addAttachment($attachment, 'SalesReport.pdf', 'application/pdf');
	$mail->setFrom($CompanyName . "<" . $CompanyRecord['Email'] . ">");
	$result = $mail->send($Recipients);

} else {
	$mail->setText("Error running automated sales report number $ReportID");
	$mail->setFrom($CompanyName . "<" . $CompanyRecord['Email'] . ">");
	$result = $mail->send($Recipients);
}

?>


