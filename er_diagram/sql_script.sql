/*
Created		27/7/2013
Modified		6/8/2013
Project		
Model		
Company		
Author		
Version		
Database		mySQL 5 
*/




drop table IF EXISTS tbl_plev;
drop table IF EXISTS tbl_ktyp;
drop table IF EXISTS tbl_ekpo;
drop table IF EXISTS tbl_ekko;
drop table IF EXISTS tbl_ebpo;
drop table IF EXISTS tbl_jobp;
drop table IF EXISTS tbl_jobk;
drop table IF EXISTS tbl_jtyp;
drop table IF EXISTS tbl_styp;
drop table IF EXISTS tbl_doct;
drop table IF EXISTS tbl_tax1;
drop table IF EXISTS tbl_apov;
drop table IF EXISTS tbl_psal;
drop table IF EXISTS tbl_kna1;
drop table IF EXISTS tbl_vbap;
drop table IF EXISTS tbl_vbak;
drop table IF EXISTS tbl_gjou;
drop table IF EXISTS tbl_ggrp;
drop table IF EXISTS tbl_glno;
drop table IF EXISTS tbl_trpo;
drop table IF EXISTS tbl_trko;
drop table IF EXISTS tbl_reson;
drop table IF EXISTS tbl_ttyp;
drop table IF EXISTS tbl_unit;
drop table IF EXISTS tbl_mwar;
drop table IF EXISTS tbl_mgrp;
drop table IF EXISTS tbl_mtyp;
drop table IF EXISTS tbl_dist;
drop table IF EXISTS tbl_vtyp;
drop table IF EXISTS tbl_lfa1;
drop table IF EXISTS tbl_mara;
drop table IF EXISTS tbl_ebko;
drop table IF EXISTS tbl_init;
drop table IF EXISTS tbl_user;
drop table IF EXISTS tbl_auth;
drop table IF EXISTS tbl_pr_item;
drop table IF EXISTS tbl_pr;




Create table tbl_pr (
	id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	code Varchar(20),
	create_date Datetime,
	create_by Varchar(100),
	update_date Datetime,
	update_by Varchar(100),
 Primary Key (id)) ENGINE = InnoDB;

Create table tbl_pr_item (
	id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	code Char(20),
	pr_id Int UNSIGNED,
	price Decimal(10,2),
	amount Decimal(6,2) UNSIGNED DEFAULT 0,
	create_date Datetime,
	create_by Varchar(100),
	update_date Datetime,
	update_by Varchar(100),
 Primary Key (id)) ENGINE = InnoDB;

Create table tbl_auth (
	autnr Varchar(10) NOT NULL COMMENT 'Authorize ID',
	objnr Varchar(10) COMMENT 'Object Code',
	activ Varchar(1) COMMENT 'Active Status',
 Primary Key (autnr)) ENGINE = InnoDB
COMMENT = 'Authorize Object';

Create table tbl_user (
	uname Varchar(10) NOT NULL COMMENT 'User ID',
	name1 Varchar(35),
	name2 Varchar(10),
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	ort01 Varchar(40) COMMENT 'City',
	distr Varchar(4) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	posit Varchar(10) COMMENT 'Position',
	passw Varchar(20) COMMENT 'Password',
	autnr Char(20) COMMENT 'Authorize ID (tbl_auth)',
 Primary Key (uname)) ENGINE = InnoDB
COMMENT = 'User Login';

Create table tbl_init (
	objnr Varchar(10) NOT NULL COMMENT 'Object id',
	perio Varchar(6) COMMENT 'Period',
	minnr Varchar(10) COMMENT 'Initial no',
	maxnr Varchar(10) COMMENT 'Limit no',
 Primary Key (objnr)) ENGINE = InnoDB
COMMENT = 'Running no.';

Create table tbl_ebko (
	purnr Varchar(10) NOT NULL COMMENT 'PR no.',
	bldat Date COMMENT 'PR Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'PR Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	sgtxt Varchar(40) COMMENT 'Text Note',
	lfdat Date COMMENT 'Delivery Date',
	lifnr Varchar(10) COMMENT 'Vendor (tbl_lfa1)',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	beamt Decimal(17,2) COMMENT 'Amt Before Vat',
	dismt Decimal(17,2) COMMENT 'Discount',
	taxpr Decimal(17,2) COMMENT 'Tax percent',
	netwr Decimal(17,2) COMMENT 'Net Amt',
	reanr Varchar(4) COMMENT 'Reject Reason no. (tbl_reson->type->02)',
 Primary Key (purnr)) ENGINE = InnoDB
COMMENT = 'PR Header Doc';

Create table tbl_mara (
	matnr Varchar(10) NOT NULL COMMENT 'Material Code',
	maktx Varchar(40) COMMENT 'Material Description',
	maken Varchar(40) COMMENT 'Material Name EN',
	erdat Datetime COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create name',
	lvorm Varchar(1) COMMENT 'Delete Flage',
	matkl Varchar(4) COMMENT 'Material Group (tbl_mgrp)',
	mtart Varchar(4) COMMENT 'Material Type (tbl_mtyp)',
	meins Varchar(3) COMMENT 'Unit',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	pleve Varchar(4) COMMENT 'Cost Level',
	updat Datetime COMMENT 'Update Date',
	upnam Varchar(10) COMMENT 'Update Name',
	beqty Decimal(15,2) COMMENT 'Beginning Qty',
	beval Decimal(17,2) COMMENT 'Beginning Value',
 Primary Key (matnr)) ENGINE = InnoDB
COMMENT = 'Material Master';

Create table tbl_lfa1 (
	lifnr Varchar(10) NOT NULL COMMENT 'Vendor Code',
	name1 Varchar(35) COMMENT 'Vendor Name1',
	name2 Varchar(10) COMMENT 'Vendor Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	ort01 Varchar(40) COMMENT 'City',
	distr Varchar(4) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxnr Varchar(4) COMMENT 'Tax type (tbl_tax1)',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	taxid Varchar(15) COMMENT 'Tax ID',
	retax Varchar(1) COMMENT 'Tax Return',
	crdit Int COMMENT 'Credit Amount',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	apamt Decimal(17,2) COMMENT 'Approve Amount',
	begin Decimal(17,2) COMMENT 'Beginning Amount',
	endin Decimal(17,2) COMMENT 'Ending Amount',
	sgtxt Varchar(40) COMMENT 'Text Note',
	vtype Varchar(4) COMMENT 'Vendor Type (tbl_vtyp)',
	erdat Datetime COMMENT 'Creaate Date',
	ernam Varchar(10) COMMENT 'Create Name',
	email Varchar(20) COMMENT 'Email',
 Primary Key (lifnr)) ENGINE = InnoDB
COMMENT = 'Vendor Master';

Create table tbl_vtyp (
	vtype Varchar(4) NOT NULL COMMENT 'Vendor type',
	ventx Varchar(40) COMMENT 'Vendor Type Desc',
 Primary Key (vtype)) ENGINE = InnoDB
COMMENT = 'Vendor Type';

Create table tbl_dist (
	distr Varchar(4) NOT NULL COMMENT 'District Code',
	distx Varchar(40) COMMENT 'District Desc',
 Primary Key (distr)) ENGINE = InnoDB
COMMENT = 'District Master';

Create table tbl_mtyp (
	mtart Varchar(4) NOT NULL COMMENT 'Material Type',
	matxt Varchar(40) COMMENT 'Mat Type Desc',
 Primary Key (mtart)) ENGINE = InnoDB
COMMENT = 'Material Type';

Create table tbl_mgrp (
	matkl Varchar(4) NOT NULL COMMENT 'Material Group',
	matxt Varchar(40) COMMENT 'Mat Grp Desc',
 Primary Key (matkl)) ENGINE = InnoDB
COMMENT = 'Material Group';

Create table tbl_mwar (
	warnr Varchar(4) NOT NULL COMMENT 'Warehouse id',
	watxt Varchar(40) COMMENT 'Warehouse Desc',
 Primary Key (warnr)) ENGINE = InnoDB
COMMENT = 'Warehouse';

Create table tbl_unit (
	meins Varchar(4) NOT NULL COMMENT 'Unit Code',
	metxt Varchar(40) COMMENT 'Unit Desc',
 Primary Key (meins)) ENGINE = InnoDB
COMMENT = 'Unit';

Create table tbl_ttyp (
	ttype Varchar(4) NOT NULL COMMENT 'Transaction type',
	typtx Varchar(40) COMMENT 'Transaction Desc',
 Primary Key (ttype)) ENGINE = InnoDB
COMMENT = 'Transaction type';

Create table tbl_reson (
	reanr Varchar(4) NOT NULL COMMENT 'Reason code',
	rtype Varchar(4) NOT NULL COMMENT 'Reason type',
	typtx Varchar(40) COMMENT 'Type Desc',
	reatx Varchar(40) COMMENT 'Reason Text',
 Primary Key (reanr,rtype)) ENGINE = InnoDB
COMMENT = 'Reason type';

Create table tbl_trko (
	trdoc Varchar(10) NOT NULL COMMENT 'Transaction no.',
	bldat Date COMMENT 'Transaction Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(40) COMMENT 'TR Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	waout Varchar(4) COMMENT 'Warehouse Out',
	warin Varchar(4) COMMENT 'Warehouse In',
	reanr Varchar(4) COMMENT 'Reason Type (tbl_reson->type->01)',
 Primary Key (trdoc)) ENGINE = InnoDB
COMMENT = 'Transaction Header Doc';

Create table tbl_trpo (
	trdoc Varchar(10) NOT NULL COMMENT 'Transaction no.',
	trapo Varchar(4) NOT NULL COMMENT 'Transaction Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
 Primary Key (trdoc,trapo)) ENGINE = InnoDB
COMMENT = 'Transaction Item';

Create table tbl_glno (
	saknr Varchar(10) NOT NULL COMMENT 'GL Acount',
	sgtxt Varchar(40) COMMENT 'GL Text',
	entxt Varchar(40) COMMENT 'GL Eng Text',
	xbilk Varchar(1) COMMENT 'Balance sheet account',
	erdat Datetime COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create Name',
	glgrp Varchar(4) COMMENT 'Account Group (tbl_ggrp)',
	gltyp Varchar(4) COMMENT 'Account type (1->Group,2->Subordinate)',
	xloev Varchar(1) COMMENT 'Delete Flag',
	debit Decimal(17,2) COMMENT 'Debit Beginning',
	credi Decimal(17,2) COMMENT 'Credit Beginning',
	under Varchar(10) COMMENT 'Under GL Account',
 Primary Key (saknr)) ENGINE = InnoDB
COMMENT = 'GL Account';

Create table tbl_ggrp (
	glgrp Varchar(4) NOT NULL COMMENT 'Account Group',
	grptx Varchar(40) COMMENT 'Account Grp Desc',
 Primary Key (glgrp)) ENGINE = InnoDB
COMMENT = 'Account Group';

Create table tbl_gjou (
	jounr Varchar(2) NOT NULL COMMENT 'Jounal no',
	joutx Varchar(40) COMMENT 'Jounal Text',
 Primary Key (jounr)) ENGINE = InnoDB
COMMENT = 'Jounal type';

Create table tbl_vbak (
	vbeln Varchar(10) NOT NULL COMMENT 'Sale Order no',
	bldat Date COMMENT 'SO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	payty Varchar(4) COMMENT 'Pay Type',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	waerk Varchar(3) COMMENT 'Currency',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
 Primary Key (vbeln)) ENGINE = InnoDB
COMMENT = 'Sale Order Header';

Create table tbl_vbap (
	vbeln Varchar(10) NOT NULL COMMENT 'SO no.',
	vbelp Varchar(4) NOT NULL COMMENT 'SO Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	dismt Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
 Primary Key (vbeln,vbelp)) ENGINE = InnoDB
COMMENT = 'SO Item';

Create table tbl_kna1 (
	kunnr Varchar(10) NOT NULL COMMENT 'Customer Code',
	name1 Varchar(35) COMMENT 'Vendor Name1',
	name2 Varchar(10) COMMENT 'Vendor Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	ort01 Varchar(40) COMMENT 'City',
	distr Varchar(4) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxnr Varchar(4) COMMENT 'Tax type (tbl_tax1)',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	pleve Varchar(4) COMMENT 'Price Level (tbl_plev)',
	retax Varchar(1) COMMENT 'Tax Return',
	crdit Int COMMENT 'Credit Amount',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	apamt Decimal(17,2) COMMENT 'Approve Amount',
	begin Decimal(17,2) COMMENT 'Beginning Amount',
	endin Decimal(17,2) COMMENT 'Ending Amount',
	sgtxt Varchar(40) COMMENT 'Text Note',
	ktype Varchar(4) COMMENT 'Customer Type (tbl_ktyp)',
	erdat Varchar(10) COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create Name',
	email Varchar(20) COMMENT 'Email',
	taxid Varchar(15) COMMENT 'Tax ID',
 Primary Key (kunnr)) ENGINE = InnoDB
COMMENT = 'Customer Master';

Create table tbl_psal (
	salnr Varchar(10) NOT NULL COMMENT 'Sale Person',
	name1 Varchar(35) COMMENT 'Vendor Name1',
	name2 Varchar(10) COMMENT 'Vendor Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	ort01 Varchar(40) COMMENT 'City',
	distr Varchar(4) COMMENT 'District',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxbs Varchar(30) COMMENT 'Tax no',
	saknr Varchar(10) COMMENT 'GL Account',
	ptype Varchar(2) COMMENT 'Price type',
	retax Varchar(1) COMMENT 'Tax Return',
	crdit Decimal(17,2) COMMENT 'Credit Amount',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	pappr Decimal(17,2) COMMENT 'Approve Amount',
	begn1 Decimal(17,2) COMMENT 'Start Amt1',
	endn1 Decimal(17,2) COMMENT 'Ending Amt1',
	sgtxt Varchar(40) COMMENT 'Text Note',
	stype Varchar(4) COMMENT 'Customer Type',
	begn2 Decimal(17,2) COMMENT 'Start Amt2',
	begn3 Decimal(17,2) COMMENT 'Start Amt3',
	endn2 Decimal(17,2) COMMENT 'Ending Amt2',
	endn3 Decimal(17,2) COMMENT 'Ending Amt3',
	perc1 Int COMMENT 'Percent 1',
	perc2 Int COMMENT 'Percent 2',
	perc3 Int COMMENT 'Percent 3',
 Primary Key (salnr)) ENGINE = InnoDB
COMMENT = 'Sale Person';

Create table tbl_apov (
	statu Varchar(4) NOT NULL COMMENT 'Approve Status',
	statx Varchar(40) COMMENT 'Approve Text',
 Primary Key (statu)) ENGINE = InnoDB
COMMENT = 'Approve Status';

Create table tbl_tax1 (
	taxnr Varchar(4) NOT NULL COMMENT 'Tax Type',
	taxtx Varchar(40) COMMENT 'Tax Type Desc',
 Primary Key (taxnr)) ENGINE = InnoDB
COMMENT = 'Tax Type';

Create table tbl_doct (
	docty Varchar(4) NOT NULL COMMENT 'Doc Type',
	doctx Varchar(40) COMMENT 'Doc Type Desc',
 Primary Key (docty)) ENGINE = InnoDB
COMMENT = 'Doc Type';

Create table tbl_styp (
	stype Varchar(4) NOT NULL COMMENT 'Sale type',
	sgtxt Varchar(40) COMMENT 'Sale type Desc',
 Primary Key (stype)) ENGINE = InnoDB
COMMENT = 'Sale type';

Create table tbl_jtyp (
	jtype Varchar(4) NOT NULL COMMENT 'Job type',
	jobtx Varchar(40) COMMENT 'Job type Desc',
 Primary Key (jtype)) ENGINE = InnoDB
COMMENT = 'Job type';

Create table tbl_jobk (
	jobnr Varchar(10) NOT NULL COMMENT 'Job No',
	jobtx Varchar(50) COMMENT 'Job name',
	jtype Varchar(4) COMMENT 'Job Type (tbl_jtyp)',
	bldat Date COMMENT 'Transaction Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Job Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	salnr Varchar(10) COMMENT 'Sale no',
	netwr Decimal(17,2) COMMENT 'Net Amount',
 Primary Key (jobnr)) ENGINE = InnoDB
COMMENT = 'Job Header';

Create table tbl_jobp (
	jobnr Varchar(10) NOT NULL COMMENT 'Job No',
	jobpo Varchar(4) NOT NULL COMMENT 'Job Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	duedt Date COMMENT 'Due Date',
	dueam Decimal(17,2) COMMENT 'Due Amt',
 Primary Key (jobnr,jobpo)) ENGINE = InnoDB
COMMENT = 'Job Item';

Create table tbl_ebpo (
	purnr Varchar(10) NOT NULL COMMENT 'PR no.',
	purpo Varchar(5) COMMENT 'PR item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
	dismt Decimal(17,2) COMMENT 'Discount Amt',
 Primary Key (purnr)) ENGINE = InnoDB
COMMENT = 'PR Item';

Create table tbl_ekko (
	ebeln Varchar(10) NOT NULL COMMENT 'PO no.',
	bldat Date COMMENT 'PO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'PO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	sgtxt Varchar(40) COMMENT 'Text Note',
	lfdat Date COMMENT 'Delivery Date',
	lifnr Varchar(10) COMMENT 'Vendor (tbl_lfa1)',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	beamt Decimal(17,2) COMMENT 'Amt Before Vat',
	dismt Decimal(17,2) COMMENT 'Discount',
	taxpr Decimal(17,2) COMMENT 'Tax percent',
	netwr Decimal(17,2) COMMENT 'Net Amt',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
 Primary Key (ebeln)) ENGINE = InnoDB
COMMENT = 'PO Header Doc';

Create table tbl_ekpo (
	ebeln Varchar(10) NOT NULL COMMENT 'PO no.',
	ebelp Varchar(5) COMMENT 'PO item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
	dismt Decimal(17,2) COMMENT 'Discount Amt',
 Primary Key (ebeln)) ENGINE = InnoDB
COMMENT = 'PO Item';

Create table tbl_ktyp (
	ktype Varchar(4) NOT NULL COMMENT 'Customer type',
	custx Varchar(40) COMMENT 'Customer Type Desc',
 Primary Key (ktype)) ENGINE = InnoDB
COMMENT = 'Customer Type';

Create table tbl_plev (
	pleve Varchar(4) NOT NULL COMMENT 'Price Level',
	matnr Varchar(10) NOT NULL COMMENT 'Material Code',
	unit Varchar(3) COMMENT 'Unit 1 (tbl_unit)',
	cost Decimal(17,2) COMMENT 'Cost 1',
 Primary Key (pleve,matnr)) ENGINE = InnoDB
COMMENT = 'Cost/Price Level';











INSERT INTO tbl_pr (code) VALUES ('A0001'),('A0002');

INSERT INTO tbl_pr_item (code, pr_id, price) VALUES ('ITEM01', 1, 2000);

INSERT INTO tbl_ggrp (glgrp, grptx) VALUES ('1', 'Asset'),('2', 'Liabibities'),('3', 'Costs'),('4', 'Income'),('5', 'Expense');

INSERT INTO tbl_gjou (jounr, joutx) VALUES ('01', 'General'),('02', 'Pay'),('03', 'Receive'),('04', 'Sale'),('05', 'Buy');

INSERT INTO tbl_glno (saknr,sgtxt,erdat,ernam,glgrp,gltyp,under) 
        VALUES ('100000','Asset','2013/07/02','ASD','1','1','1'),
               ('110000','Current Asset','2013/07/02','ASD','1','1','100000'),
               ('111000','Cash&Bank','2013/07/02','ASD','1','1','110000'),
               ('111100','Cash','2013/07/02','ASD','1','2','111000'),
               ('111200','Bank','2013/07/02','ASD','1','1','111000'),
               ('111210','Credit Card','2013/07/02','ASD','1','2','111200'),
               ('111211','Current-BKK','2013/07/02','ASD','1','2','111200'),
               ('111212','Current-KBank','2013/07/02','ASD','1','2','111200'),
               ('200000','Liabibity','2013/07/02','ASD','2','1','2'),
               ('210000','Current Liabibity','2013/07/02','ASD','2','1','200000'),
               ('211000','A/C Payable Purchase','2013/07/02','ASD','2','1','210000'),
               ('211001','A/C Payable Purchase','2013/07/02','ASD','2','2','211000'),
               ('300000','Shareholders Equity','2013/07/02','ASD','3','1','3'),
               ('310000','Share Capital','2013/07/02','ASD','3','2','300000'),
               ('400000','Revenue','2013/07/02','ASD','4','1','4'),
               ('410000','Revenue-Sale','2013/07/02','ASD','4','1','400000'),
               ('411000','Sale','2013/07/02','ASD','4','2','410000'),
               ('500000','Expense','2013/07/02','ASD','5','1','5'),
               ('510000','Cost of Goods Sold','2013/07/02','ASD','5','1','500000'),
               ('511000','Cost of Sale','2013/07/02','ASD','5','2','510000'),
               ('512000','Net Purchasing','2013/07/02','ASD','5','1','511000'),
               ('512010','Purchasing','2013/07/02','ASD','5','2','512000'),
               ('512020','Receive Decrease','2013/07/02','ASD','5','2','512000'),
               ('512030','Return Goods','2013/07/02','ASD','5','2','512000');
               
INSERT INTO tbl_doct (docty, doctx) VALUES ('QT', 'Quotation'),('SO', 'Sale Order'),('IV', 'Invoice');

INSERT INTO tbl_mwar (warnr, watxt) VALUES ('RM', 'Raw Mat'),('FG', 'Finish Goods'),('GM', 'General Mat');

INSERT INTO tbl_mtyp (mtart, matxt) VALUES ('EX', 'Expense'),('IN', 'Income');

INSERT INTO tbl_mgrp (matkl, matxt) VALUES ('RM', 'Raw Mat'),('FG', 'Finish Goods'),('GM', 'General Mat');

INSERT INTO tbl_unit (meins, metxt) VALUES ('EA', 'Eeach'),('BOX', 'Box'),('CAN', 'Can'),('DOZ', 'Dozen'),
('KG', 'Kilogram'),('g', 'Gram'),('BOT', 'Bottle');

INSERT INTO tbl_dist (distr, distx) VALUES ('01', 'Bangkok'),('02', 'Ayutaya'),('03', 'Nakronpatom'),('04', 'Cholburi'),
('05', 'Nakronrachasima'),('06', 'Saraburi'),('07', 'Supan');

INSERT INTO tbl_mara (matnr,maktx,mtart,matkl,erdat,ernam,meins,saknr) 
        VALUES ('100001','RM Mat test1','EX','RM','2013/07/02','ASD','EA','100001'),
               ('100002','RM Mat test2','EX','RM','2013/07/02','ASD','EA','100001'),
               ('200001','FG Mat test1','IN','FG','2013/07/02','ASD','BOX','100002'),
               ('200002','FG Mat test2','IN','FG','2013/07/02','ASD','BOX','100002');
               
INSERT INTO tbl_apov (statu, statx) VALUES ('01', 'Waiting Approve'),('02', 'Approved'),('03', 'Unapproved'),('04', 'Rejected');

INSERT INTO tbl_tax1 (taxnr, taxtx) VALUES ('01', 'Include Tax'),('02', 'Separate Tax'),('03', 'Tax Zero'),('04', 'Except Tax');

INSERT INTO tbl_doct (doctx, docty) VALUES ('QA', 'Quotation'),('VA', 'Sale Order');

INSERT INTO tbl_styp (stype, sgtxt) VALUES ('01', 'Material Sales by Cash'),('02', 'Material Sales on Credit'),
('03', 'Service Sales by Cash'),('04', 'Service Sales on Credit');

INSERT INTO tbl_jtyp (jtype, jobtx) VALUES ('01', 'Website'),('02', 'Printing'),
('03', 'Board'),('04', 'Event');

INSERT INTO tbl_reson (reanr,rtype, typtx, reatx) 
        VALUES ('01', '01', 'Transaction Mat', 'Balance'),
               ('20', '01', 'Transaction Mat', 'General Recieve'),
               ('21', '01', 'Transaction Mat', 'Purchase'),
               ('30', '01', 'Transaction Mat', 'Sale'),
               ('01', '02', 'Reject Reason', 'Defective product'),
               ('02', '02', 'Reject Reason', 'Absence product'),
               ('03', '02', 'Reject Reason', 'Over product'),
               ('04', '02', 'Reject Reason', 'Wrong product'),
               ('05', '02', 'Reject Reason', 'Over price'),
               ('06', '02', 'Reject Reason', 'Wrong price');

INSERT INTO tbl_plev (pleve, ) VALUES ('01','100001','EA','200'),('02','100001','Dozen','2400'),('03','100001','Dozen2','4800'),
('01','100002','EA','300'),('02','100002','Dozen','1200'),('03','100002','Dozen2','3600'),
('01','200001','EA','400'),('02','200001','Dozen','2400'),('03','200001','Dozen2','4800'),
('01','200002','EA','500'),('02','200002','Dozen','2000'),('03','200002','Dozen2','4000');
               
INSERT INTO tbl_kna1 (kunnr,name1,adr01,adr02,distr,pstlz,telf1,taxnr,pleve,crdit,disct,taxid,) 
        VALUES ('100001','A-Link Network Co.,Ld.','811 Soi Takham Praram2 Rd.','Praram 2','Bangkok','10150','02-2222222','02','01','10000','500','330111001'),
               ('100002','Prime Accounting Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','03','20000','5%','330111002'),
               ('100003','Prime BizNet Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','03','30000','10%','330111002'),
               ('100004','Prime Consulting Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','03','40000','800','330111002');
               
INSERT INTO tbl_lfa1 (lifnr,name1,adr01,adr02,distr,pstlz,telf1,taxnr,crdit,disct,taxid,) 
        VALUES ('200001','Mana Construction Co.,Ld.','811 Soi Takham Praram2 Rd.','Praram 2','Bangkok','10150','02-2222222','02','10000','500','330111001'),
               ('200002','Atime Media Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','10000','500','330111002'),
               ('200003','Grammy Entainment Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','10000','500','330111002'),
               ('200004','RS Promotion Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','10000','500','330111002');



