/*
Created		27/7/2013
Modified		29/10/2013
Project		
Model		
Company		
Author		
Version		
Database		mySQL 5 
*/



Drop View IF EXISTS v_vtyp
;

Drop View IF EXISTS v_ebbk
;

Drop View IF EXISTS v_ebbp
;

Drop View IF EXISTS v_ebkp
;

Drop View IF EXISTS v_ebkk
;

Drop View IF EXISTS v_ebrp
;

Drop View IF EXISTS v_ebrk
;

Drop View IF EXISTS v_lfa1
;

Drop View IF EXISTS v_vbkp
;

Drop View IF EXISTS v_vbkk
;

Drop View IF EXISTS v_bcus
;

Drop View IF EXISTS v_vbop
;

Drop View IF EXISTS v_vbok
;

Drop View IF EXISTS v_ktyp
;

Drop View IF EXISTS v_conp
;

Drop View IF EXISTS v_mseg
;

Drop View IF EXISTS v_mkpf
;

Drop View IF EXISTS v_rgl
;

Drop View IF EXISTS v_bkpf
;

Drop View IF EXISTS v_trko
;

Drop View IF EXISTS v_trpo
;

Drop View IF EXISTS v_paym
;

Drop View IF EXISTS v_vbbp
;

Drop View IF EXISTS v_vbbk
;

Drop View IF EXISTS v_ebpo
;

Drop View IF EXISTS v_ekpo
;

Drop View IF EXISTS v_kna1
;

Drop View IF EXISTS v_ebko
;

Drop View IF EXISTS v_ekko
;

Drop View IF EXISTS v_bsid
;

Drop View IF EXISTS v_vbrp
;

Drop View IF EXISTS v_vbrk
;

Drop View IF EXISTS v_vbap
;

Drop View IF EXISTS v_jobk
;

Drop View IF EXISTS v_vbak
;




drop table IF EXISTS tbl_comp;
drop table IF EXISTS tbl_ebkp;
drop table IF EXISTS tbl_ebkk;
drop table IF EXISTS tbl_vbkp;
drop table IF EXISTS tbl_vbkk;
drop table IF EXISTS tbl_conp;
drop table IF EXISTS tbl_cont;
drop table IF EXISTS tbl_bcus;
drop table IF EXISTS tbl_trpo;
drop table IF EXISTS tbl_trko;
drop table IF EXISTS tbl_ebbp;
drop table IF EXISTS tbl_ebbk;
drop table IF EXISTS tbl_ebrp;
drop table IF EXISTS tbl_ebrk;
drop table IF EXISTS tbl_bnam;
drop table IF EXISTS tbl_paym;
drop table IF EXISTS tbl_vbbp;
drop table IF EXISTS tbl_vbbk;
drop table IF EXISTS tbl_mkpf;
drop table IF EXISTS tbl_mseg;
drop table IF EXISTS tbl_cond;
drop table IF EXISTS tbl_bven;
drop table IF EXISTS tbl_vbok;
drop table IF EXISTS tbl_vbop;
drop table IF EXISTS tbl_vbrp;
drop table IF EXISTS tbl_bsid;
drop table IF EXISTS tbl_bkpf;
drop table IF EXISTS tbl_vbrk;
drop table IF EXISTS tbl_payp;
drop table IF EXISTS tbl_ctyp;
drop table IF EXISTS tbl_ptyp;
drop table IF EXISTS tbl_clev;
drop table IF EXISTS tbl_apop;
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
	mtart Varchar(4),
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
	modul Varchar(4) NOT NULL COMMENT 'Module',
	grpmo Varchar(4) NOT NULL COMMENT 'Module grp',
	sgtxt Varchar(40) COMMENT 'Object Description',
	short Varchar(2) COMMENT 'Short Letter',
	minnr Varchar(10) COMMENT 'Initial no',
	maxnr Varchar(10) COMMENT 'Limit no',
	perio Varchar(6) COMMENT 'Period',
	curnr Varchar(10) COMMENT 'Current no',
	tname Varchar(8) COMMENT 'Table Name',
	tcode Varchar(5) COMMENT 'Field Doc code',
 Primary Key (objnr,modul)) ENGINE = InnoDB
COMMENT = 'Running no.';

Create table tbl_ebko (
	purnr Varchar(20) NOT NULL COMMENT 'PR no.',
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
	terms Int COMMENT 'Credit terms',
	refnr Varchar(40) COMMENT 'Referance',
	taxnr Varchar(4) COMMENT 'Tax type',
	vat01 Decimal(17,2),
	ptype Varchar(4),
	exchg Decimal(15,4),
	ctype Varchar(3),
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
	name1 Varchar(40) COMMENT 'Vendor Name1',
	name2 Varchar(40) COMMENT 'Vendor Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	dis02 Varchar(40) COMMENT 'City',
	distx Varchar(40) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxnr Varchar(4) COMMENT 'Tax type (tbl_tax1)',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	taxid Varchar(15) COMMENT 'Tax ID',
	retax Varchar(1) COMMENT 'Tax Return',
	crdit Int COMMENT 'Long-term',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	apamt Decimal(17,2) COMMENT 'Approve Amount',
	begin Decimal(17,2) COMMENT 'Beginning Amount',
	endin Decimal(17,2) COMMENT 'Ending Amount',
	note1 Varchar(40) COMMENT 'Text Note',
	vtype Varchar(4) COMMENT 'Vendor Type (tbl_vtyp)',
	erdat Datetime COMMENT 'Creaate Date',
	ernam Varchar(10) COMMENT 'Create Name',
	email Varchar(20) COMMENT 'Email',
	psl02 Varchar(10) COMMENT 'Post Code2',
	tel02 Varchar(30) COMMENT 'Tel Phone2',
	telf2 Varchar(30) COMMENT 'Fax2',
	pson2 Varchar(30) COMMENT 'Person2',
	emai2 Varchar(20) COMMENT 'Email2',
	cunt1 Varchar(20),
	cunt2 Varchar(20),
	statu Varchar(4),
	ptype Varchar(4) COMMENT 'payment type',
	vat01 Decimal(15,2) COMMENT 'Vat Value',
 Primary Key (lifnr)) ENGINE = InnoDB
COMMENT = 'Vendor Master';

Create table tbl_vtyp (
	vtype Varchar(4) NOT NULL COMMENT 'Vendor type',
	ventx Varchar(40) COMMENT 'Vendor Type Desc',
	saknr Varchar(10) COMMENT 'gl no',
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
	saknr Varchar(10),
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
	tname Varchar(20),
	tcode Varchar(20),
	modul Varchar(20),
 Primary Key (ttype)) ENGINE = InnoDB
COMMENT = 'Transaction type';

Create table tbl_reson (
	reanr Varchar(4) NOT NULL COMMENT 'Reason code',
	rtype Varchar(4) NOT NULL COMMENT 'Reason type',
	typtx Varchar(40) COMMENT 'Type Desc',
	reatx Varchar(40) COMMENT 'Reason Text',
 Primary Key (reanr,rtype)) ENGINE = InnoDB
COMMENT = 'Reason type';

Create table tbl_glno (
	saknr Varchar(10) NOT NULL COMMENT 'GL Acount',
	sgtxt Varchar(40) COMMENT 'GL Text',
	entxt Varchar(40) COMMENT 'GL Eng Text',
	gltyp Varchar(1) COMMENT 'GL Type (''1''->Debit, ''2''->Credit)',
	erdat Datetime COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create Name',
	glgrp Varchar(4) COMMENT 'Account Group (tbl_ggrp)',
	gllev Varchar(4) COMMENT 'Account type (1->Group,2->Subordinate)',
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
	vbeln Varchar(20) NOT NULL COMMENT 'Quotation no',
	bldat Date COMMENT 'Quotation Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Quotation Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(20) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Varchar(20) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
	whtpr Decimal(17,2) COMMENT 'WHT Value',
	vat01 Decimal(17,2) COMMENT 'Vat amt',
	wht01 Decimal(17,2) COMMENT 'WHT amt',
 Primary Key (vbeln)) ENGINE = InnoDB
COMMENT = 'Quotation Header';

Create table tbl_vbap (
	vbeln Varchar(20) NOT NULL COMMENT 'Quotation no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Quotation Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	dismt Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	chk01 Varchar(1),
	chk02 Varchar(1),
 Primary Key (vbeln,vbelp)) ENGINE = InnoDB
COMMENT = 'Quotation Item';

Create table tbl_kna1 (
	kunnr Varchar(10) NOT NULL COMMENT 'Customer Code',
	name1 Varchar(40) COMMENT 'Customer Name1',
	name2 Varchar(40) COMMENT 'Customer Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	dis02 Varchar(40) COMMENT 'Distrct1',
	distx Varchar(40) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxnr Varchar(4) COMMENT 'Tax type (tbl_tax1)',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	pleve Varchar(4) COMMENT 'Price Level (tbl_plev)',
	retax Varchar(1) COMMENT 'Tax Return',
	terms Int COMMENT 'Long-term',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	apamt Decimal(17,2) COMMENT 'Approve Amount',
	begin Decimal(17,2) COMMENT 'Beginning Amount',
	endin Decimal(17,2) COMMENT 'Ending Amount',
	note1 Varchar(40) COMMENT 'Text Note',
	ktype Varchar(4) COMMENT 'Customer Type (tbl_ktyp)',
	erdat Datetime COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create Name',
	email Varchar(20) COMMENT 'Email',
	taxid Varchar(15) COMMENT 'Tax ID',
	pst02 Varchar(10) COMMENT 'Post Code2',
	tel02 Varchar(30) COMMENT 'Tel Phone2',
	telf2 Varchar(30) COMMENT 'Fax2',
	pson2 Varchar(30) COMMENT 'Person2',
	emai2 Varchar(20) COMMENT 'Email2',
	cunt1 Varchar(20),
	cunt2 Varchar(20),
	statu Varchar(4),
	ptype Varchar(4) COMMENT 'payment type',
	vat01 Decimal(15,2) COMMENT 'Vat value',
 Primary Key (kunnr)) ENGINE = InnoDB
COMMENT = 'Customer Master';

Create table tbl_psal (
	salnr Varchar(10) NOT NULL COMMENT 'Sale Person',
	name1 Varchar(35) COMMENT 'Vendor Name1',
	name2 Varchar(10) COMMENT 'Vendor Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	ort01 Varchar(40) COMMENT 'City',
	distx Varchar(40) COMMENT 'District',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	taxbs Varchar(30) COMMENT 'Tax no',
	saknr Varchar(10) COMMENT 'GL Account',
	ctype Varchar(2) COMMENT 'Comission type (''01''->Levels,''02''->Step',
	goals Decimal(17,2) COMMENT 'Sale Goal',
	stdat Date COMMENT 'Start Date',
	endat Date COMMENT 'End Date',
	sgtxt Varchar(40) COMMENT 'Text Note',
	percs Decimal(17,2) COMMENT 'Percent',
 Primary Key (salnr)) ENGINE = InnoDB
COMMENT = 'Sale Person';

Create table tbl_apov (
	statu Varchar(4) NOT NULL COMMENT 'Approve Status',
	apgrp Varchar(1) NOT NULL COMMENT 'Aprove group',
	statx Varchar(40) COMMENT 'Approve Text',
 Primary Key (statu,apgrp)) ENGINE = InnoDB
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
	jobnr Varchar(20) NOT NULL COMMENT 'Job No',
	jobtx Varchar(50) COMMENT 'Job name',
	jtype Varchar(4) COMMENT 'Job Type (tbl_jtyp)',
	bldat Date COMMENT 'Transaction Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Job Status (tbl_apop)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	salnr Varchar(10) COMMENT 'Sale no',
	stdat Date COMMENT 'Start Date',
	endat Date COMMENT 'End Date',
	datam Int COMMENT 'Long-term',
	kunnr Varchar(10) COMMENT 'Customer id (tbl_kna1)',
	pson1 Varchar(40) COMMENT 'Contact person',
	pramt Decimal(17,2) COMMENT 'Project amount',
	esamt Decimal(17,2) COMMENT 'Estimate cost',
	ctype Varchar(3) COMMENT 'Currency type',
 Primary Key (jobnr)) ENGINE = InnoDB
COMMENT = 'Job Header';

Create table tbl_jobp (
	jobnr Varchar(20) NOT NULL COMMENT 'Job No',
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
	purnr Varchar(20) NOT NULL COMMENT 'PR no.',
	purpo Varchar(5) NOT NULL COMMENT 'PR item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
	disit Decimal(17,2) COMMENT 'Discount Amt',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	ctype Varchar(3) COMMENT 'Currency',
	chk01 Varchar(5),
 Primary Key (purnr,purpo)) ENGINE = InnoDB
COMMENT = 'PR Item';

Create table tbl_ekko (
	ebeln Varchar(20) NOT NULL COMMENT 'PO no.',
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
	purnr Varchar(20) COMMENT 'Purchase Order (tbl_ebko)',
	terms Int COMMENT 'Credit terms',
	refnr Varchar(40) COMMENT 'Referance',
	taxnr Varchar(4) COMMENT 'Tax type',
	ptype Varchar(4) COMMENT 'Payment type',
	vat01 Decimal(17,2),
	exchg Decimal(15,4),
	ctype Varchar(3),
 Primary Key (ebeln)) ENGINE = InnoDB
COMMENT = 'PO Header Doc';

Create table tbl_ekpo (
	ebeln Varchar(20) NOT NULL COMMENT 'PO no.',
	ebelp Varchar(5) NOT NULL COMMENT 'PO item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
	disit Decimal(17,2) COMMENT 'Discount Amt',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	ctype Varchar(3) COMMENT 'Currency',
	chk01 Varchar(5),
 Primary Key (ebeln,ebelp)) ENGINE = InnoDB
COMMENT = 'PO Item';

Create table tbl_ktyp (
	ktype Varchar(4) NOT NULL COMMENT 'Customer type',
	custx Varchar(40) COMMENT 'Customer Type Desc',
	saknr Varchar(10) COMMENT 'GL no',
 Primary Key (ktype)) ENGINE = InnoDB
COMMENT = 'Customer Type';

Create table tbl_plev (
	pleve Varchar(4) NOT NULL COMMENT 'Price Level',
	matnr Varchar(10) NOT NULL COMMENT 'Material Code',
	unit Varchar(3) COMMENT 'Unit 1 (tbl_unit)',
	cost Decimal(17,2) COMMENT 'Cost 1',
 Primary Key (pleve,matnr)) ENGINE = InnoDB
COMMENT = 'Cost/Price Level';

Create table tbl_apop (
	statu Varchar(4) NOT NULL COMMENT 'Approve Status',
	statx Varchar(40) COMMENT 'Approve Text',
 Primary Key (statu)) ENGINE = InnoDB
COMMENT = 'Approve Status for Project managment';

Create table tbl_clev (
	cleve Varchar(4) NOT NULL COMMENT 'Comission Level',
	salnr Varchar(10) NOT NULL COMMENT 'Sale Code',
	beamt Decimal(17,2) COMMENT 'Start Amount',
	enamt Decimal(17,2) COMMENT 'Start Amount',
	perce Decimal(17,2) COMMENT 'Percent',
 Primary Key (cleve,salnr)) ENGINE = InnoDB
COMMENT = 'Comission Level';

Create table tbl_ptyp (
	ptype Varchar(4) NOT NULL COMMENT 'Pay type',
	paytx Varchar(40) COMMENT 'Pay Type Desc',
	saknr Varchar(10) COMMENT 'gl no',
 Primary Key (ptype)) ENGINE = InnoDB
COMMENT = 'Payment Method';

Create table tbl_ctyp (
	ctype Varchar(4) NOT NULL COMMENT 'Currency type',
	curtx Varchar(40) COMMENT 'Currency Desc',
 Primary Key (ctype)) ENGINE = InnoDB
COMMENT = 'Currency Type';

Create table tbl_payp (
	vbeln Varchar(20) NOT NULL COMMENT 'Quotation no.',
	paypr Varchar(4) NOT NULL COMMENT 'Period Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	sgtxt Varchar(40) COMMENT 'Description Text',
	duedt Date COMMENT 'Due Date',
	perct Decimal(17,2) COMMENT 'Percent',
	pramt Decimal(17,2) COMMENT 'Period Amount',
	ctyp1 Varchar(3) COMMENT 'Currency',
	statu Varchar(4) COMMENT 'Aprove Status (tbl_apov)',
 Primary Key (vbeln,paypr)) ENGINE = InnoDB
COMMENT = 'Partial Payment Periods';

Create table tbl_vbrk (
	invnr Varchar(20) NOT NULL COMMENT 'Invoice no',
	bldat Date COMMENT 'Invoice Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	itype Varchar(4) COMMENT 'Invoice type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Varchar(20) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
	ordnr Varchar(20) COMMENT 'SO no (tbl_vbok)',
	condi Varchar(4) COMMENT 'Payment Condition',
	paypr Varchar(4) COMMENT 'Partial Payment',
	whtpr Decimal(17,2),
	vat01 Decimal(17,2),
	wht01 Decimal(17,2),
 Primary Key (invnr)) ENGINE = InnoDB
COMMENT = 'Invoice Header';

Create table tbl_bkpf (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	belnr Varchar(20) NOT NULL COMMENT 'Doc no',
	gjahr Varchar(4) NOT NULL COMMENT 'Fiscal Year',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	tranr Varchar(10) COMMENT 'Transaction No (tbl_trko)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ttype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	vbeln Varchar(10) COMMENT 'SO no',
	blart Varchar(2) COMMENT 'Doc type',
	invnr Varchar(20) COMMENT 'Invoice no',
 Primary Key (bukrs,belnr,gjahr)) ENGINE = InnoDB
COMMENT = 'GL Header Doc';

Create table tbl_bsid (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	belnr Varchar(20) NOT NULL COMMENT 'Doc no',
	gjahr Varchar(4) NOT NULL COMMENT 'Fiscal Year',
	belpr Varchar(3) NOT NULL COMMENT 'Line item',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	augdt Date COMMENT 'Clearing date',
	augbl Varchar(10) COMMENT 'Clearing Doc',
	shkzg Varchar(1) COMMENT 'Debit/Credit ind.',
	debit Decimal(17,2) COMMENT 'Debit Amt',
	credi Decimal(17,2) COMMENT 'Credit Amt',
 Primary Key (bukrs,belnr,gjahr,belpr)) ENGINE = InnoDB
COMMENT = 'GL Item (Customer)';

Create table tbl_vbrp (
	invnr Varchar(20) NOT NULL COMMENT 'Invoice no.',
	vbelp Varchar(4) NOT NULL COMMENT 'SO Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	dismt Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
 Primary Key (invnr,vbelp)) ENGINE = InnoDB
COMMENT = 'Invoice Item';

Create table tbl_vbop (
	ordnr Varchar(20) NOT NULL COMMENT 'SO no.',
	vbelp Varchar(4) NOT NULL COMMENT 'SO Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	disit Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	chk01 Varchar(5),
	chk02 Varchar(5),
 Primary Key (ordnr,vbelp)) ENGINE = InnoDB
COMMENT = 'SO Item';

Create table tbl_vbok (
	ordnr Varchar(20) NOT NULL COMMENT 'Sale Order no',
	bldat Date COMMENT 'SO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	vbeln Varchar(20) COMMENT 'Quotation No (tbl_vbak)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
	whtpr Decimal(17,2),
	vat01 Decimal(17,2),
	wht01 Decimal(17,2),
 Primary Key (ordnr)) ENGINE = InnoDB
COMMENT = 'Sale Order Header';

Create table tbl_bven (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	belnr Varchar(20) NOT NULL COMMENT 'Doc no',
	gjahr Varchar(4) NOT NULL COMMENT 'Fiscal Year',
	belpr Varchar(3) NOT NULL COMMENT 'Line item',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	augdt Date COMMENT 'Clearing date',
	augbl Varchar(10) COMMENT 'Clearing Doc',
	shkzg Varchar(1) COMMENT 'Debit/Credit ind.',
	debit Decimal(17,2) COMMENT 'Debit Amt',
	credi Decimal(17,2) COMMENT 'Credit Amt',
 Primary Key (bukrs,belnr,gjahr,belpr)) ENGINE = InnoDB
COMMENT = 'GL Item (Vendor)';

Create table tbl_cond (
	condi Varchar(4) NOT NULL COMMENT 'Payment Condition type',
	contx Varchar(40) COMMENT 'Condition Desc',
 Primary Key (condi)) ENGINE = InnoDB
COMMENT = 'Payment Condition Type';

Create table tbl_mseg (
	mbeln Varchar(20) NOT NULL COMMENT 'Mat doc no.',
	mbelp Varchar(5) NOT NULL COMMENT 'mat doc item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code (tbl_mara)',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit (tbl_unit)',
	disit Decimal(17,2) COMMENT 'Discount Amt',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	ctype Varchar(3) COMMENT 'Currency',
	chk01 Varchar(5),
 Primary Key (mbeln,mbelp)) ENGINE = InnoDB
COMMENT = 'Mat doc Item';

Create table tbl_mkpf (
	mbeln Varchar(20) NOT NULL COMMENT 'mat doc no.',
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
	purnr Varchar(20) COMMENT 'Purchase Order (tbl_ebko)',
	refnr Varchar(40) COMMENT 'Referance',
	taxnr Varchar(4) COMMENT 'Tax type',
	ptype Varchar(4) COMMENT 'Payment type',
	ebeln Varchar(20) COMMENT 'PO no. (tbl_ekko)',
	terms Int,
	vat01 Decimal(17,2),
	ctype Varchar(3),
	exchg Decimal(15,4),
 Primary Key (mbeln)) ENGINE = InnoDB
COMMENT = 'Mat Doc';

Create table tbl_vbbk (
	recnr Varchar(20) NOT NULL COMMENT 'Receipt no',
	bldat Date NOT NULL COMMENT 'SO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(20) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
 Primary Key (recnr)) ENGINE = InnoDB
COMMENT = 'Receipt Header';

Create table tbl_vbbp (
	recnr Varchar(20) NOT NULL COMMENT 'Receipt no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Receipt Item',
	invnr Varchar(20) COMMENT 'Invoice no.',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	recbl Varchar(20) COMMENT 'Receipt billing  ',
	invdt Date COMMENT 'Invoice Date',
	texts Varchar(40) COMMENT 'Text Note',
	reman Decimal(17,2) COMMENT 'Remain Amt',
	payrc Decimal(17,2) COMMENT 'Payment receipt',
	refnr Varchar(40) COMMENT 'Ref no.',
 Primary Key (recnr,vbelp)) ENGINE = InnoDB
COMMENT = 'Receipt Item';

Create table tbl_paym (
	recnr Varchar(20) NOT NULL COMMENT 'Receipt no.',
	paypr Varchar(4) NOT NULL COMMENT 'Pay Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	sgtxt Varchar(40) COMMENT 'Description Text',
	chqdt Date COMMENT 'Cheque Date',
	perct Decimal(17,2) COMMENT 'Percent',
	pramt Decimal(17,2) COMMENT 'Period Amount',
	ctyp1 Varchar(3) COMMENT 'Currency',
	statu Varchar(4) COMMENT 'Aprove Status (tbl_apov)',
	ptype Varchar(4) COMMENT 'Payment type',
	bcode Varchar(10) COMMENT 'Bank code',
	chqid Varchar(10) COMMENT 'Cheque Code',
	ccode Varchar(4) COMMENT 'Cheque code',
	reman Decimal(17,2) COMMENT 'Remain Amt',
	payam Decimal(17,2) COMMENT 'Pay Amount',
 Primary Key (recnr,paypr)) ENGINE = InnoDB
COMMENT = 'Partial Payment Periods';

Create table tbl_bnam (
	bcode Varchar(10) NOT NULL COMMENT 'Bank Code',
	bname Varchar(60) COMMENT 'Bank name',
	bthai Varchar(60) COMMENT 'Thai Name',
	saknr Varchar(10) COMMENT 'gl no',
	addrs Varchar(100) COMMENT 'Address',
 Primary Key (bcode)) ENGINE = InnoDB
COMMENT = 'Bank Name';

Create table tbl_ebrk (
	invnr Varchar(20) NOT NULL COMMENT 'Invoice no',
	bldat Date COMMENT 'Invoice Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	itype Varchar(4) COMMENT 'Invoice type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lifnr Varchar(10) COMMENT 'Vendor no (tbl_lfa1)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Varchar(20) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	vbeln Varchar(20) COMMENT 'QT no (tbl_vbak)',
	condi Varchar(4) COMMENT 'Payment Condition',
	paypr Varchar(4) COMMENT 'Partial Payment',
	belnr Varchar(20) COMMENT 'GL Doc',
	lfdat Date COMMENT 'Delivery Date',
	mbeln Varchar(20) COMMENT 'Mat doc no.',
	terms Int COMMENT 'Credit terms',
	sgtxt Varchar(40) COMMENT 'Text Note',
	vat01 Decimal(17,2),
 Primary Key (invnr)) ENGINE = InnoDB
COMMENT = 'Invoice Header';

Create table tbl_ebrp (
	invnr Varchar(20) NOT NULL COMMENT 'Invoice no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Invoice Item',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	disit Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	chk01 Varchar(5),
 Primary Key (invnr,vbelp)) ENGINE = InnoDB
COMMENT = 'Invoice Item';

Create table tbl_ebbk (
	payno Varchar(20) NOT NULL COMMENT 'Payment no',
	bldat Date NOT NULL COMMENT 'Payment Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(20) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	lifnr Varchar(10) COMMENT 'Vendor no (tbl_lfa1)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	vat01 Decimal(17,2),
 Primary Key (payno)) ENGINE = InnoDB
COMMENT = 'Payment Header';

Create table tbl_ebbp (
	payno Varchar(20) NOT NULL COMMENT 'Payment no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Payment Item',
	invnr Varchar(20) COMMENT 'Invoice no.',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	disit Decimal(17,2) COMMENT 'Discount amt',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	recbl Varchar(20) COMMENT 'Receipt billing  ',
	invdt Date COMMENT 'Invoice Date',
	texts Varchar(40) COMMENT 'Text Note',
	reman Decimal(17,2) COMMENT 'Remain Amt',
	payrc Decimal(17,2) COMMENT 'Payment receipt',
	refnr Varchar(40) COMMENT 'Ref no.',
	chk01 Varchar(5),
 Primary Key (payno,vbelp)) ENGINE = InnoDB
COMMENT = 'Receipt Item';

Create table tbl_trko (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	tranr Varchar(20) NOT NULL COMMENT 'Transaction no',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
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
	ttype Varchar(4) COMMENT 'Journal Type (tbl_ttyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	vbeln Varchar(10) COMMENT 'SO no',
	blart Varchar(2) COMMENT 'Doc type',
	invnr Varchar(10) COMMENT 'Invoice no',
 Primary Key (bukrs,tranr)) ENGINE = InnoDB
COMMENT = 'Journal Templete Header';

Create table tbl_trpo (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	tranr Varchar(20) NOT NULL COMMENT 'Transaction no',
	trapr Varchar(3) NOT NULL COMMENT 'Line item',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	augdt Date COMMENT 'Clearing date',
	augbl Varchar(10) COMMENT 'Clearing Doc',
	shkzg Varchar(1) COMMENT 'Debit/Credit ind.',
	debit Decimal(17,2) COMMENT 'Debit Amt',
	credi Decimal(17,2) COMMENT 'Credit Amt',
 Primary Key (bukrs,tranr,trapr)) ENGINE = InnoDB
COMMENT = 'Journal Templete Item';

Create table tbl_bcus (
	bukrs Varchar(4) NOT NULL COMMENT 'Company Code',
	belnr Varchar(20) NOT NULL COMMENT 'Doc no',
	gjahr Varchar(4) NOT NULL COMMENT 'Fiscal Year',
	belpr Varchar(3) NOT NULL COMMENT 'Line item',
	bldat Date COMMENT 'Invoice Date',
	budat Date COMMENT 'Posting Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'Invoice Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(10) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	lidat Int COMMENT 'Limit Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,3) COMMENT 'Exchange rate',
	saknr Varchar(10) COMMENT 'GL No',
	augdt Date COMMENT 'Clearing date',
	augbl Varchar(10) COMMENT 'Clearing Doc',
	shkzg Varchar(1) COMMENT 'Debit/Credit ind.',
	debit Decimal(17,2) COMMENT 'Debit Amt',
	credi Decimal(17,2) COMMENT 'Credit Amt',
 Primary Key (bukrs,belnr,gjahr,belpr)) ENGINE = InnoDB
COMMENT = 'GL Item (Customer)';

Create table tbl_cont (
	conty Varchar(4) NOT NULL COMMENT 'Codition type',
	contx Varchar(40) COMMENT 'Condition Desc',
	vtamt Decimal(17,2) COMMENT 'Vat amt',
	ttamt Decimal(17,2) COMMENT 'Amount',
 Primary Key (conty)) ENGINE = InnoDB
COMMENT = 'Condition Price';

Create table tbl_conp (
	connr Varchar(20) NOT NULL COMMENT 'Doc no',
	conpr Varchar(6) NOT NULL COMMENT 'Doc item',
	conty Varchar(4) COMMENT 'Condition type',
	vtamt Decimal(17,2) COMMENT 'Amount',
 Primary Key (connr,conpr)) ENGINE = InnoDB
COMMENT = 'Condition Price';

Create table tbl_vbkk (
	bilnr Varchar(20) NOT NULL COMMENT 'Billto no',
	bldat Date NOT NULL COMMENT 'SO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(20) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	kunnr Varchar(10) COMMENT 'Cutomer no (tbl_kunnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
 Primary Key (bilnr)) ENGINE = InnoDB
COMMENT = 'Billto Header';

Create table tbl_vbkp (
	bilnr Varchar(20) NOT NULL COMMENT 'Billto no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Billto Item',
	invnr Varchar(20) COMMENT 'Invoice no.',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	recbl Varchar(20) COMMENT 'Receipt billing  ',
	invdt Date COMMENT 'Invoice Date',
	texts Varchar(40) COMMENT 'Text Note',
	reman Decimal(17,2) COMMENT 'Remain Amt',
	payrc Decimal(17,2) COMMENT 'Payment receipt',
	refnr Varchar(40) COMMENT 'Ref no.',
 Primary Key (bilnr,vbelp)) ENGINE = InnoDB
COMMENT = 'Billto Item';

Create table tbl_ebkk (
	bilnr Varchar(20) NOT NULL COMMENT 'Billfrom no',
	bldat Date NOT NULL COMMENT 'SO Date',
	loekz Varchar(1) COMMENT 'Delete flag',
	statu Varchar(4) COMMENT 'SO Status (tbl_apov)',
	ernam Varchar(10) COMMENT 'Create name',
	erdat Datetime COMMENT 'Create date',
	txz01 Varchar(40) COMMENT 'Text Note',
	jobnr Varchar(20) COMMENT 'Job No (tbl_jobk)',
	revnr Varchar(10) COMMENT 'Reverse Doc',
	upnam Varchar(10) COMMENT 'Update Name',
	updat Datetime COMMENT 'Update Date',
	auart Varchar(4) COMMENT 'SO type',
	salnr Varchar(10) COMMENT 'Sale person (tbl_psal)',
	reanr Varchar(4) COMMENT 'Reject Reason (tbl_reson->type->02)',
	refnr Varchar(15) COMMENT 'Refer doc',
	ptype Varchar(4) COMMENT 'Pay Type (tbl_ptyp)',
	taxnr Varchar(4) COMMENT 'Tax Type (tbl_tax1)',
	terms Int COMMENT 'Terms Date',
	lifnr Varchar(10) COMMENT 'Vendor no (tbl_lifnr)',
	netwr Decimal(17,2) COMMENT 'Net Amount',
	ctype Varchar(3) COMMENT 'Currency (tbl_ctyp)',
	beamt Decimal(17,2) COMMENT 'Amount',
	dismt Decimal(10,2) COMMENT 'Discount amt',
	taxpr Decimal(17,2) COMMENT 'Percent Tax',
	duedt Date COMMENT 'Due Date',
	docty Varchar(4) COMMENT 'Doc type (tbl_doct)',
	exchg Decimal(15,4) COMMENT 'Exchange rate',
 Primary Key (bilnr)) ENGINE = InnoDB
COMMENT = 'Billfrom Header';

Create table tbl_ebkp (
	bilnr Varchar(20) NOT NULL COMMENT 'Billto no.',
	vbelp Varchar(4) NOT NULL COMMENT 'Billto Item',
	invnr Varchar(20) COMMENT 'Invoice no.',
	loekz Varchar(1) COMMENT 'Delete flag',
	matnr Varchar(10) COMMENT 'Material Code',
	menge Decimal(15,2) COMMENT 'Amount',
	meins Varchar(3) COMMENT 'Unit',
	warnr Varchar(4) COMMENT 'Warehouse code',
	ctype Varchar(3) COMMENT 'Currency',
	unitp Decimal(17,2) COMMENT 'Price/Unit',
	itamt Decimal(17,2) COMMENT 'Item Amount',
	recbl Varchar(20) COMMENT 'Receipt billing  ',
	invdt Date COMMENT 'Invoice Date',
	texts Varchar(40) COMMENT 'Text Note',
	reman Decimal(17,2) COMMENT 'Remain Amt',
	payrc Decimal(17,2) COMMENT 'Payment receipt',
	refnr Varchar(40) COMMENT 'Ref no.',
 Primary Key (bilnr,vbelp)) ENGINE = InnoDB
COMMENT = 'Bill from Item';

Create table tbl_comp (
	bukrs Varchar(10) NOT NULL COMMENT 'Customer Code',
	name1 Varchar(40) COMMENT 'Company Name1',
	name2 Varchar(40) COMMENT 'Company Name2',
	adr01 Varchar(40) COMMENT 'Address 1',
	adr02 Varchar(40) COMMENT 'Address 2',
	dis02 Varchar(40) COMMENT 'Distrct1',
	distx Varchar(40) COMMENT 'District (tbl_dist)',
	pstlz Varchar(10) COMMENT 'Post Code',
	telf1 Varchar(30) COMMENT 'Telephon',
	telfx Varchar(30) COMMENT 'Fax No',
	pson1 Varchar(30) COMMENT 'Contact Person',
	taxnr Varchar(4) COMMENT 'Tax type (tbl_tax1)',
	saknr Varchar(10) COMMENT 'GL Account (tbl_glno)',
	pleve Varchar(4) COMMENT 'Price Level (tbl_plev)',
	retax Varchar(1) COMMENT 'Tax Return',
	terms Int COMMENT 'Long-term',
	disct Decimal(17,2) COMMENT 'Discount Amount',
	apamt Decimal(17,2) COMMENT 'Approve Amount',
	begin Decimal(17,2) COMMENT 'Beginning Amount',
	endin Decimal(17,2) COMMENT 'Ending Amount',
	note1 Varchar(40) COMMENT 'Text Note',
	ktype Varchar(4) COMMENT 'Customer Type (tbl_ktyp)',
	erdat Datetime COMMENT 'Create Date',
	ernam Varchar(10) COMMENT 'Create Name',
	email Varchar(20) COMMENT 'Email',
	taxid Varchar(15) COMMENT 'Tax ID',
	pst02 Varchar(10) COMMENT 'Post Code2',
	tel02 Varchar(30) COMMENT 'Tel Phone2',
	telf2 Varchar(30) COMMENT 'Fax2',
	pson2 Varchar(30) COMMENT 'Person2',
	emai2 Varchar(20) COMMENT 'Email2',
	cunt1 Varchar(20),
	cunt2 Varchar(20),
	statu Varchar(4),
	ptype Varchar(4) COMMENT 'payment type',
	vat01 Decimal(15,2) COMMENT 'Vat value',
 Primary Key (bukrs)) ENGINE = InnoDB
COMMENT = 'Company Master';












create view v_vbak as

select a.*,
`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`telf2`,`b`.`adr02`,`b`.`tel02`,`b`.`pst02`,
`b`.`emai2`,`b`.`dis02`,`c`.`name1` AS `sname`,d.statx,e.jobtx 
from tbl_vbak a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_psal c on a.salnr = c.salnr
left join tbl_apov d on a.statu = d.statu
left join tbl_jobk e on a.jobnr = e.jobnr;
create view v_jobk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx` AS `distx`,`b`.`telf2`,`b`.`adr02`,`b`.`tel02`,`b`.`pst02`,
`b`.`emai2`,`b`.`dis02`,`c`.`name1` AS `sname`,d.statx 
from tbl_jobk a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_psal c on a.salnr = c.salnr
left join tbl_apov d on a.statu = d.statu;
create view v_vbap as

select a.*,b.maktx
from tbl_vbap a left join tbl_mara b 
on a.matnr = b.matnr;
create view v_vbrk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`telf2`,`b`.`adr02`,`b`.`tel02`,`b`.`pst02`,
`b`.`emai2`,`b`.`dis02`,`b`.`saknr` as cusgl,c.name1 as sname,d.statx,
e.paytx,e.saknr, h.belnr
from tbl_vbrk a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_psal c on a.salnr = c.salnr
left join tbl_apov d on a.statu = d.statu
left join tbl_ptyp e on a.ptype = e.ptype
left join tbl_bkpf h on a.invnr = h.invnr;
create view v_vbrp as

select a.*,b.maktx,b.mtart
from tbl_vbrp a left join tbl_mara b 
on a.matnr = b.matnr;
create view v_bsid as

select a.*,b.sgtxt
from tbl_bsid a left join tbl_glno b 
on a.saknr = b.saknr;
create view v_ekko as

SELECT a.*,b.name1,
`b`.`telf1` AS `telf1`,`b`.`adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,c.statx
			FROM tbl_ekko AS a 
				inner join tbl_lfa1 AS b ON a.lifnr=b.lifnr
				inner join tbl_apov AS c ON a.statu=c.statu;
create view v_ebko as

SELECT t1.*,name1,t2.adr01,t2.distx,t2.pstlz,t2.telf1,t2.telfx,t2.email,t3.statx
			FROM tbl_ebko AS t1 inner join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
			inner join tbl_apov AS t3 ON t1.statu=t3.statu;
create view v_kna1 as

SELECT t1.*,
	t2.custx,t3.sgtxt
FROM tbl_kna1 AS t1
LEFT JOIN tbl_ktyp AS t2 
ON t1.ktype = t2.ktype
left join tbl_glno as t3
on t1.saknr = t3.saknr;
create view v_ekpo as

SELECT t1.*,t2.maktx
FROM tbl_ekpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr;
create view v_ebpo as

SELECT t1.*,t2.maktx
FROM tbl_ebpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr;
create view v_vbbk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`saknr` as cusgl,d.statx,e.paytx,e.saknr 
from tbl_vbbk a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_apov d on a.statu = d.statu
left join tbl_ptyp e on a.ptype = e.ptype;
create view v_vbbp as

SELECT t1.*,t2.name1,
t3.vbelp,t3.invnr,t3.invdt,t3.itamt,t3.texts
FROM tbl_vbbk AS t1 
left join tbl_kna1 AS t2 ON t1.kunnr=t2.kunnr
left join tbl_vbbp AS t3 ON t1.recnr=t3.recnr;
create view v_paym as

SELECT a.*,b.bname
FROM tbl_paym AS a left join tbl_bnam AS b ON a.bcode=b.bcode;
create view v_trpo as

SELECT t1.*,t2.sgtxt
FROM tbl_trpo AS t1 inner join tbl_glno AS t2 ON t1.saknr=t2.saknr;
create view v_trko as

SELECT t1.*,t2.typtx
FROM tbl_trko AS t1 inner join tbl_ttyp AS t2 ON t1.ttype=t2.ttype;
create view v_bkpf as

select a.*,b.typtx,c.txz01 as trantx
from tbl_bkpf a left join tbl_ttyp b 
on a.ttype = b.ttype
left join tbl_trko c 
on a.tranr = c.tranr;
create view v_rgl as

select a.saknr,a.sgtxt

,IF((select sum(b.debit) from tbl_bsid as b where b.saknr = a.saknr) IS NULL, 0, (select sum(b.debit) from tbl_bsid as b where b.saknr = a.saknr))
 +IF((select sum(c.debit) from tbl_bcus as c where c.saknr = a.saknr) IS NULL, 0, (select sum(c.debit) from tbl_bcus as c where c.saknr = a.saknr))
 as deb1
,IF((select sum(d.credi) from tbl_bsid as d where d.saknr = a.saknr) IS NULL, 0, (select sum(d.credi) from tbl_bsid as d where d.saknr = a.saknr))
 +IF((select sum(e.credi) from tbl_bcus as e where e.saknr = a.saknr) IS NULL, 0, (select sum(e.credi) from tbl_bcus as e where e.saknr = a.saknr))
as cre1
from tbl_glno a group by a.saknr;
CREATE view  v_mkpf AS

select t1.*,t2.distx,
t2.pstlz,t2.telf1,
t2.telfx,t2.email,
t2.name1,t2.adr01,
t3.statx
from tbl_mkpf t1 inner join tbl_lfa1 t2 on t1.lifnr = t2.lifnr inner 
join tbl_apov t3 on t1.statu = t3.statu;
CREATE VIEW v_mseg AS 

select tbl_mseg.*,tbl_mara.maktx,
tbl_mara.maken,tbl_mara.erdat,tbl_mara.ernam,tbl_mara.lvorm,
tbl_mara.matkl,tbl_mara.mtart,tbl_mara.saknr,tbl_mara.pleve,
tbl_mara.updat,tbl_mara.upnam,tbl_mara.beqty,tbl_mara.beval
from tbl_mseg inner join tbl_mara 
on tbl_mseg. matnr =  tbl_mara.matnr;
create view v_conp as

select a.*,b.contx
from tbl_conp a left join tbl_cont b 
on a.conty = b.conty;
create view v_ktyp as

select a.*,b.sgtxt
from tbl_ktyp a left join tbl_glno b 
on a.saknr = b.saknr;
create view v_vbok as

select a.*,
`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`telf2`,`b`.`adr02`,`b`.`tel02`,`b`.`pst02`,
`b`.`emai2`,`b`.`dis02`,`c`.`name1` AS `sname`,d.statx
from tbl_vbok a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_psal c on a.salnr = c.salnr
left join tbl_apov d on a.statu = d.statu;
create view v_vbop as

select a.*,b.maktx
from tbl_vbop a left join tbl_mara b 
on a.matnr = b.matnr;
create view v_bcus as

select a.*,b.sgtxt
from tbl_bcus a left join tbl_glno b 
on a.saknr = b.saknr;

create view v_vbkk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`saknr` as cusgl,d.statx
from tbl_vbkk a left join tbl_kna1 b 
on a.kunnr = b.kunnr
left join tbl_apov d on a.statu = d.statu;
create view v_vbkp as

SELECT t1.*,t2.name1,
t3.vbelp,t3.invnr,t3.invdt,t3.itamt,t3.texts
FROM tbl_vbkk AS t1 
left join tbl_kna1 AS t2 ON t1.kunnr=t2.kunnr
left join tbl_vbkp AS t3 ON t1.bilnr=t3.bilnr;
create view v_lfa1 as

SELECT t1.*,
	t2.ventx,t3.sgtxt
FROM tbl_lfa1 AS t1
LEFT JOIN tbl_vtyp AS t2 
ON t1.vtype = t2.vtype
left join tbl_glno as t3
on t1.saknr = t3.saknr;
create view v_ebrk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,
`b`.`saknr` as cusgl,c.name1 as sname,d.statx,
e.paytx,e.saknr, h.belnr
from tbl_ebrk a left join tbl_lfa1 b 
on a.lifnr = b.lifnr
left join tbl_psal c on a.salnr = c.salnr
left join tbl_apov d on a.statu = d.statu
left join tbl_ptyp e on a.ptype = e.ptype
left join tbl_bkpf h on a.invnr = h.invnr;
create view v_ebrp as

select a.*,b.maktx,b.mtart
from tbl_ebrp a left join tbl_mara b 
on a.matnr = b.matnr;
create view v_ebkk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`saknr` as cusgl,d.statx
from tbl_ebkk a left join tbl_lfa1 b 
on a.lifnr = b.lifnr
left join tbl_apov d on a.statu = d.statu;
create view v_ebkp as

SELECT t1.*,t2.name1,
t3.vbelp,t3.invnr,t3.invdt,t3.itamt,t3.texts
FROM tbl_ebkk AS t1 
left join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
left join tbl_ebkp AS t3 ON t1.bilnr=t3.bilnr;
create view v_ebbp as

SELECT t1.*,t2.name1,
t3.vbelp,t3.invnr,t3.invdt,t3.itamt,t3.texts
FROM tbl_ebbk AS t1 
left join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
left join tbl_ebbp AS t3 ON t1.payno=t3.payno;
create view v_ebbk as

select a.*,`b`.`name1` AS `name1`,
`b`.`telf1` AS `telf1`,`b`.`adr01` AS `adr01`,`b`.`telfx` AS `telfx`,`b`.`pstlz` AS `pstlz`,
`b`.`email` AS `email`,`b`.`distx`,`b`.`saknr` as cusgl,d.statx,e.paytx,e.saknr 
from tbl_ebbk a left join tbl_lfa1 b 
on a.lifnr = b.lifnr
left join tbl_apov d on a.statu = d.statu
left join tbl_ptyp e on a.ptype = e.ptype;
create view v_vtyp as

select a.*,b.sgtxt
from tbl_vtyp a left join tbl_glno b 
on a.saknr = b.saknr;


INSERT INTO tbl_pr (code) VALUES ('A0001'),('A0002');

INSERT INTO tbl_pr_item (code, pr_id, price) VALUES ('ITEM01', 1, 2000);

INSERT INTO tbl_init (objnr,modul,grpmo,sgtxt,short,minnr,maxnr,perio,curnr,tname,tcode) 
               VALUES ('0001','PJ','PS','Project Job','PJ','1000','9999','1308','1000','tbl_jobk','jobnr'),
                      ('0002','QT','SD','Quotation','QT','1000','9999','1308','2000','tbl_vbak','vbeln'),
                      ('0003','IV','SD','Invoice','IV','1000','9999','1308','3000','tbl_vbrk','invnr'),
                      ('0004','DR','SD','Deposit Receipt','DR','1000','9999','1308','4000','tbl_jobk','vbeln'),
                      ('0005','PL','SD','Packing List','PL','1000','9999','1308','5000','tbl_jobk','vbeln'),
                      ('0006','PT','SD','Product Return','PT','1000','9999','1308','6000','tbl_jobk','vbeln'),
                      ('0007','PR','MM','Purchase Requisition','PR','1000','9999','1308','1000','tbl_ebko','purnr'),
                      ('0008','PO','MM','Purchase Order','PO','1000','9999','1308','2000','tbl_ekko','ebeln'),
                      ('0009','GR','MM','Goods Receipt','GR','1000','9999','1308','3000','tbl_egko','mbeln'),
                      ('0010','MT','MM','Material Transactin','MT','1000','9999','1308','4000','tbl_jobk','vbeln'),
                      ('0011','CS','SD','Customer','1','0001','99999','1308','10000','tbl_kna1','kunnr'),
                      ('0012','VD','MM','Vendor','2','0001','99999','1308','20000','tbl_lfa1','lifnr'),
                      ('0013','SP','SD','Sale Person','3','0001','99999','1308','30000','tbl_psal','salnr'),
                      ('0014','RD','AC','Reciept Doc','RD','1000','9999','1308','30000','tbl_vbbk','recnr'),
                      ('0015','PD','AC','Payment Doc','PD','1000','9999','1308','30000','tbl_ebbk','payno'),
                      ('0016','AR','AC','Account Recieveable','AR','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0017','AP','AC','Account Payable','AP','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0018','PV','AC','Account Payabled','PV','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0019','RV','AC','Account Receipted','RV','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0020','PC','AC','Cheque Payment','PC','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0021','RC','AC','Cheque Receipt','RC','10000','99999','1308','30000','tbl_bkpf','belnr'),
                      ('0022','AD','AC','AP Doc','AD','1000','9999','1308','30000','tbl_ebrk','invnr'),
                      ('0023','SO','SD','Sale Order','SO','1000','9999','1308','2000','tbl_vbok','ordnr'),
                      ('0024','BT','SD','Sale Order','BT','1000','9999','1308','2000','tbl_vbkk','bilnr'),
                      ('0025','BF','MM','Sale Order','BF','1000','9999','1308','2000','tbl_ebkk','bilnr');

INSERT INTO tbl_ggrp (glgrp, grptx) VALUES ('1', 'Asset'),('2', 'Liabibities'),('3', 'Costs'),('4', 'Income'),('5', 'Expense');

INSERT INTO tbl_gjou (jounr, joutx) VALUES ('01', 'General'),('02', 'Payment'),('03', 'Receive'),('04', 'Sale'),('05', 'Buy');

INSERT INTO tbl_glno (saknr,sgtxt,erdat,ernam,glgrp,gllev,gltyp,under) 
        VALUES ('100000','Asset','2013/07/02','ASD','1','1','1','1'),
               ('110000','Current Asset','2013/07/02','ASD','1','1','1','100000'),
               ('111000','Cash on hand','2013/07/02','ASD','1','1','1','110000'),
               ('111100','Petty Cash','2013/07/02','ASD','1','2','1','111000'),
               ('111200','Cash in Bank - Saving Account','2013/07/02','ASD','1','1','1','111000'),
               ('111210','Cheque Receipt','2013/07/02','ASD','1','2','1','111200'),
               ('111211','Cash in Bank - Current Account','2013/07/02','ASD','1','2','1','111200'),
               ('111212','Cash in Bank - Current Account (OD)','2013/07/02','ASD','1','2','1','111200'),
               ('112000','Account Receivable - Domestic','2013/07/02','ASD','1','2','1','110000'),
               ('112001','Account Receivable - Export','2013/07/02','ASD','1','2','1','112000'),
               ('112002','Account Receivable - Advertisement ','2013/07/02','ASD','1','2','1','112000'),
               ('112003','Account Receivable - Renting the Drama','2013/07/02','ASD','1','2','1','112000'),
               ('531503','Accounting Receivable - Rights','2013/07/02','ASD','1','2','1','112000'),
               
               ('113000','Accounting Receivable - FG','2013/07/02','ASD','1','2','1','110000'),
               ('114000','Allowance of Doubtful','2013/07/02','ASD','1','2','1','110000'),
               ('115000','Other Account Receivable','2013/07/02','ASD','1','2','1','110000'),
               ('116000','Finished Goods and Inventory','2013/07/02','ASD','1','2','1','110000'),
               ('116100','Raw Material','2013/07/02','ASD','1','2','1','116000'),
               ('116200','Work in Process','2013/07/02','ASD','1','2','1','116000'),
               ('116300','Finished Goods','2013/07/02','ASD','1','2','1','116000'),
               ('116400','Office Supply and Stationary','2013/07/02','ASD','1','2','1','116000'),
               ('116500','Bi - Finished Goods Product','2013/07/02','ASD','1','2','1','116000'),
               ('117000','Other Current Asset','2013/07/02','ASD','1','2','1','110000'),
               ('117100','Prepaid Payment','2013/07/02','ASD','1','2','1','117000'),
               ('117400','Accrue Revenue','2013/07/02','ASD','1','2','1','117000'),
              
               ('200000','Liability','2013/07/02','ASD','2','1','1','2'),
               ('210000','Current Liability','2013/07/02','ASD','2','1','1','200000'),
               ('211000','Account Payable - Domestic','2013/07/02','ASD','2','1','1','210000'),
               ('211001','Account Payable - Export','2013/07/02','ASD','2','2','1','211000'),
               ('211002','Account Payable - Renting the Drama','2013/07/02','ASD','2','2','1','211000'),
               ('211003','Account Payable - Rights','2013/07/02','ASD','2','2','1','211000'),
               ('212000','Account Payable - RM','2013/07/02','ASD','2','1','1','210000'),
               ('213000','Other Account Payable','2013/07/02','ASD','2','1','1','210000'),
               ('214000','Accrue Expense','2013/07/02','ASD','2','1','1','210000'),
               ('215000','Down Payment','2013/07/02','ASD','2','1','1','210000'),
               ('215010','Input - Output Vat','2013/07/02','ASD','2','1','1','215000'),
               ('215020','Accrue Interest Expense','2013/07/02','ASD','2','1','1','215000'),
               ('215030','Corporate Income Tax (PND51, PND50)','2013/07/02','ASD','2','1','1','215000'),
               ('215040','Witholding tax (PND53)','2013/07/02','ASD','2','1','1','215000'),
               ('215050','Witholding tax (PND3)','2013/07/02','ASD','2','1','1','215000'),
               ('215060','Witholding tax (PND1)','2013/07/02','ASD','2','1','1','215000'),
               ('215070','Social Security Fund (SSF)','2013/07/02','ASD','2','1','1','215000'),
               
               ('300000','Shareholders Equity','2013/07/02','ASD','3','1','1','3'),
               ('310000','Common Stock','2013/07/02','ASD','3','2','1','300000'),
               
               ('400000','Income and Revenue','2013/07/02','ASD','4','1','1','4'),
               ('410000','Revenue from Sale','2013/07/02','ASD','4','1','1','400000'),
               ('411000','Sale','2013/07/02','ASD','4','2','1','410000'),
               ('420000','Revenue from Service','2013/07/02','ASD','4','1','1','400000'),
               ('420010','Revenue from Service','2013/07/02','ASD','4','2','1','420000'),
               ('420020','Revenue from Renting','2013/07/02','ASD','4','2','1','420000'),
               ('420030','Revenue from Rights','2013/07/02','ASD','4','2','1','420000'),
               
               ('500000','Expense','2013/07/02','ASD','5','1','1','5'),
               ('510000','Cost of Goods Sold','2013/07/02','ASD','5','1','1','500000'),
               ('511000','Cost of Goods Sold','2013/07/02','ASD','5','2','1','510000'),
               ('512000','Purchasing','2013/07/02','ASD','5','1','1','511000'),
               ('512010','Discount, Claim and Return','2013/07/02','ASD','5','2','1','512000'),
               ('512020','Discount','2013/07/02','ASD','5','2','1','512000'),
               ('512030','Claim and Return','2013/07/02','ASD','5','2','1','512000');

               
INSERT INTO tbl_bnam (bcode, bname, addrs) VALUES 
('BOT', 'Bank of Thailand','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('BBL', 'Bangkok Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('KBANK', 'Kasikorn Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('KTB', 'Krung Thai Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('TMB', 'TMB Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('SCB', 'Siam Commercial Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('CITI', 'Citibank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('BAY', 'Ayudhaya Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('SCBT', 'Standard Chartered Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626'),
('UOB', 'United Overseas Bank','273 Samsan Rd., Bangkhunprom Bangkok 10200 Tel.0-2283-5353 Fax 0-2280-0449,0-280-0626');
               
INSERT INTO tbl_doct (docty, doctx) VALUES ('QT', 'Quotation'),('SO', 'Sale Order'),('IV', 'Invoice');

INSERT INTO tbl_mwar (warnr, watxt) VALUES ('RM', 'Raw Mat'),('FG', 'Finish Goods'),('GM', 'General Mat');

INSERT INTO tbl_mtyp (mtart, matxt, saknr) VALUES 
('RM', 'Raw Material', '116100'),
('FG', 'Finish Goods', '116200'),
('PM', 'Process Material', '116300'),
('GM', 'Gernaral Material', '116400'),
('SV', 'Service Material', '116500');

INSERT INTO tbl_ttyp (ttype, typtx, modul) VALUES ('01','Genaral Journal','JV'),('02','Payment Journal','PV'),('03','Receipt Journal','RV'),('04','Sale Journal','AR'),
('05','Purchase Journal','AP'),('06','Petty Cash Journal','PE'),('07','Cheque Receipt Journal','RC'),('08','Cheque Payment Journal','PC');

INSERT INTO tbl_ktyp (ktype, custx, saknr) VALUES ('01', 'Regular Customer', '410000'),('02', 'Temporary Customer', '411000');

INSERT INTO tbl_mgrp (matkl, matxt) VALUES ('RM', 'Raw Mat'),('FG', 'Finish Goods'),('GM', 'General Mat');

INSERT INTO tbl_conp (conty, contx) VALUES ('01', 'Vat'),('02', 'WHT');

INSERT INTO tbl_unit (meins, metxt) VALUES ('EA', 'Eeach'),('BOX', 'Box'),('CAN', 'Can'),('DOZ', 'Dozen'),
('KG', 'Kilogram'),('g', 'Gram'),('BOT', 'Bottle');

INSERT INTO tbl_dist (distr, distx) VALUES ('01', 'Bangkok'),('02', 'Ayutaya'),('03', 'Nakronpatom'),('04', 'Cholburi'),
('05', 'Nakronrachasima'),('06', 'Saraburi'),('07', 'Supan');

INSERT INTO tbl_mara (matnr,maktx,mtart,matkl,erdat,ernam,meins,saknr) 
        VALUES ('100001','Advertising Newspaper','EX','SV','2013/07/02','ASD','EA','100001'),
               ('100002','Advertising Agency','EX','SV','2013/07/02','ASD','EA','100001'),
               ('200001','Website Development','IN','SV','2013/07/02','ASD','BOX','100002'),
               ('200002','Maintenance Service','IN','SV','2013/07/02','ASD','BOX','100002');
               
INSERT INTO tbl_apov (statu, statx, apgrp) VALUES ('01', 'Waiting for Approval', '1'),('02', 'Approved', '1'),('03', 'Unapproved', '1'),('04', 'Rejected', '1'),
                                            ('05', 'Active', '2'),('06', 'Parking', '2'),('07', 'Rejected', '2');

INSERT INTO tbl_apop (statu, statx) VALUES ('01', 'Waiting for Approval'),('02', 'Approved'),('03', 'Unapproved'),('04', 'Rejected'),
                                            ('05', 'Phase 1 Completed'),('06', 'Phase 2 Completed'),('07', 'Phase 3 Completed'),('08', 'Phase 4 Completed'),
                                            ('09', 'Phase 5 Completed'),('10', 'Phase 6 Completed');

INSERT INTO tbl_tax1 (taxnr, taxtx) VALUES ('01', 'Include Vat'),('02', 'Exclude Vat');

INSERT INTO tbl_doct (doctx, docty) VALUES ('QA', 'Quotation'),('VA', 'Sale Order');

INSERT INTO tbl_styp (stype, sgtxt) VALUES ('01', 'Material Sales by Cash'),('02', 'Material Sales on Credit'),
('03', 'Service Sales by Cash'),('04', 'Service Sales on Credit');

INSERT INTO tbl_jtyp (jtype, jobtx) VALUES ('01', 'Website'),('02', 'Printing'),
('03', 'Board'),('04', 'Event');

INSERT INTO tbl_cond (condi, contx) VALUES ('01', 'After issue Invoice'),('02', 'After reciept Invoice'),
('03', 'After reciept Service/Goods');

INSERT INTO tbl_ptyp (ptype, paytx, saknr) VALUES ('01', 'Credit', '112001'),('02', 'Cash', '111100'),
('03', 'Transfers', '111200'),('04', 'Credit Card', '111200'),('05', 'Cheque', '111210');

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

INSERT INTO tbl_plev (pleve,matnr,unit,cost) VALUES ('01','100001','EA','200'),('02','100001','Dozen','2400'),('03','100001','Dozen2','4800'),
('01','100002','EA','300'),('02','100002','Dozen','1200'),('03','100002','Dozen2','3600'),
('01','200001','EA','400'),('02','200001','Dozen','2400'),('03','200001','Dozen2','4800'),
('01','200002','EA','500'),('02','200002','Dozen','2000'),('03','200002','Dozen2','4000');
               
INSERT INTO tbl_kna1 (kunnr,name1,adr01,adr02,distx,pstlz,telf1,telfx,taxnr,pleve,crdit,disct,taxid,dis02,pst02,tel02,saknr) 
        VALUES ('10001','A-Link Network Co.,Ld.','811 Soi Takham Praram2 Rd.','Praram 2','Bangkok','10150','02-2222222','02-2222223','02','01','30','500','330111001','Bangkok','10150','02-2222222','112002'),
               ('10002','Prime Accounting Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02-2222223','02','03','15','5%','330111002','Bangkok','10150','02-2222222','112003'),
               ('10003','Prime BizNet Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02-2222223','02','03','20','10%','330111002','Bangkok','10150','02-2222222','112001'),
               ('10004','Prime Consulting Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02-2222223','02','03','30','800','330111002','Bangkok','10150','02-2222222','112001');
               
INSERT INTO tbl_lfa1 (lifnr,name1,adr01,adr02,distx,pstlz,telf1,taxnr,crdit,disct,taxid,dis02,pst02,tel02,saknr) 
        VALUES ('20001','Mana Construction Co.,Ld.','811 Soi Takham Praram2 Rd.','Praram 2','Bangkok','10150','02-2222222','02','30','500','330111001','Bangkok','10150','02-2222222','211002'),
               ('20002','Atime Media Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','15','500','330111002','Bangkok','10150','02-2222222','211003'),
               ('20003','Grammy Entainment Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','20','500','330111002','Bangkok','10150','02-2222222','211001'),
               ('20004','RS Promotion Co.,Ld.','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333','02','30','500','330111002','Bangkok','10150','02-2222222','211001');
               
INSERT INTO tbl_psal (salnr,name1,adr01,adr02,distx,pstlz,telf1) 
        VALUES ('30001','Anna Jackson','811 Soi Takham Praram2 Rd.','Praram 2','Bangkok','10150','02-2222222'),
               ('30002','Mana Longru','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333'),
               ('30003','Manee Jongjit','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333'),
               ('30004','Kitti Chaiyapak','99 SapanSung  Srinakarin Rd.','Sapansung','Bangkok','10160','02-3333333');

INSERT INTO tbl_ctyp (ctype, curtx) VALUES ('THB', 'Thai baht'),('USD', 'US Dollar'),('CNY','China Yuan Renminbi'),('EUR', 'Euro Member Countries'),
('AED',	'United Arab Emirates Dirham'),
('AFN',	'Afghanistan Afghani'),
('ALL',	'Albania Lek'),
('AMD',	'Armenia Dram'),
('ANG',	'Netherlands Antilles Guilder'),
('AOA',	'Angola Kwanza'),
('ARS',	'Argentina Peso'),
('AUD',	'Australia Dollar'),
('AWG',	'Aruba Guilder'),
('AZN',	'Azerbaijan New Manat'),
('BAM',	'Bosnia and Herzegovina Convertible Marka'),
('BBD',	'Barbados Dollar'),
('BDT',	'Bangladesh Taka'),
('BGN',	'Bulgaria Lev'),
('BHD',	'Bahrain Dinar'),
('BIF',	'Burundi Franc'),
('BMD',	'Bermuda Dollar'),
('BND',	'Brunei Darussalam Dollar'),
('BOB',	'Bolivia Boliviano'),
('BRL',	'Brazil Real'),
('BSD',	'Bahamas Dollar'),
('BTN',	'Bhutan Ngultrum'),
('BWP',	'Botswana Pula'),
('BYR',	'Belarus Ruble'),
('BZD',	'Belize Dollar'),
('CAD',	'Canada Dollar'),
('CDF',	'Congo/Kinshasa Franc'),
('CHF',	'Switzerland Franc'),
('CLP',	'Chile Peso'),
('COP',	'Colombia Peso'),
('CRC',	'Costa Rica Colon'),
('CUC',	'Cuba Convertible Peso'),
('CUP',	'Cuba Peso'),
('CVE',	'Cape Verde Escudo'),
('CZK',	'Czech Republic Koruna'),
('DJF',	'Djibouti Franc'),
('DKK',	'Denmark Krone'),
('DOP',	'Dominican Republic Peso'),
('DZD',	'Algeria Dinar'),
('EGP',	'Egypt Pound'),
('ERN',	'Eritrea Nakfa'),
('ETB',	'Ethiopia Birr'),
('FJD',	'Fiji Dollar'),
('FKP',	'Falkland Islands (Malvinas) Pound'),
('GBP',	'United Kingdom Pound'),
('GEL',	'Georgia Lari'),
('GGP',	'Guernsey Pound'),
('GHS',	'Ghana Cedi'),
('GIP',	'Gibraltar Pound'),
('GMD',	'Gambia Dalasi'),
('GNF',	'Guinea Franc'),
('GTQ',	'Guatemala Quetzal'),
('GYD',	'Guyana Dollar'),
('HKD',	'Hong Kong Dollar'),
('HNL',	'Honduras Lempira'),
('HRK',	'Croatia Kuna'),
('HTG',	'Haiti Gourde'),
('HUF',	'Hungary Forint'),
('IDR',	'Indonesia Rupiah'),
('ILS',	'Israel Shekel'),
('IMP',	'Isle of Man Pound'),
('INR',	'India Rupee'),
('IQD',	'Iraq Dinar'),
('IRR',	'Iran Rial'),
('ISK',	'Iceland Krona'),
('JEP',	'Jersey Pound'),
('JMD',	'Jamaica Dollar'),
('JOD',	'Jordan Dinar'),
('JPY',	'Japan Yen'),
('KES',	'Kenya Shilling'),
('KGS',	'Kyrgyzstan Som'),
('KHR',	'Cambodia Riel'),
('KMF',	'Comoros Franc'),
('KPW',	'Korea (North) Won'),
('KRW',	'Korea (South) Won'),
('KWD',	'Kuwait Dinar'),
('KYD',	'Cayman Islands Dollar'),
('KZT',	'Kazakhstan Tenge'),
('LAK',	'Laos Kip'),
('LBP',	'Lebanon Pound'),
('LKR',	'Sri Lanka Rupee'),
('LRD',	'Liberia Dollar'),
('LSL',	'Lesotho Loti'),
('LTL',	'Lithuania Litas'),
('LVL',	'Latvia Lat'),
('LYD',	'Libya Dinar'),
('MAD',	'Morocco Dirham'),
('MDL',	'Moldova Leu'),
('MGA',	'Madagascar Ariary'),
('MKD',	'Macedonia Denar'),
('MMK',	'Myanmar (Burma) Kyat'),
('MNT',	'Mongolia Tughrik'),
('MOP',	'Macau Pataca'),
('MRO',	'Mauritania Ouguiya'),
('MUR',	'Mauritius Rupee'),
('MVR',	'Maldives (Maldive Islands) Rufiyaa'),
('MWK',	'Malawi Kwacha'),
('MXN',	'Mexico Peso'),
('MYR',	'Malaysia Ringgit'),
('MZN',	'Mozambique Metical'),
('NAD',	'Namibia Dollar'),
('NGN',	'Nigeria Naira'),
('NIO',	'Nicaragua Cordoba'),
('NOK',	'Norway Krone'),
('NPR',	'Nepal Rupee'),
('NZD',	'New Zealand Dollar'),
('OMR',	'Oman Rial'),
('PAB',	'Panama Balboa'),
('PEN',	'Peru Nuevo Sol'),
('PGK',	'Papua New Guinea Kina'),
('PHP',	'Philippines Peso'),
('PKR',	'Pakistan Rupee'),
('PLN',	'Poland Zloty'),
('PYG',	'Paraguay Guarani'),
('QAR',	'Qatar Riyal'),
('RON',	'Romania New Leu'),
('RSD',	'Serbia Dinar'),
('RUB',	'Russia Ruble'),
('RWF',	'Rwanda Franc'),
('SAR',	'Saudi Arabia Riyal'),
('SBD',	'Solomon Islands Dollar'),
('SCR',	'Seychelles Rupee'),
('SDG',	'Sudan Pound'),
('SEK',	'Sweden Krona'),
('SGD',	'Singapore Dollar'),
('SHP',	'Saint Helena Pound'),
('SLL',	'Sierra Leone Leone'),
('SOS',	'Somalia Shilling'),
('SPL',	'Seborga Luigino'),
('SRD',	'Suriname Dollar'),
('STD',	'S�o Tom� and Pr�ncipe Dobra'),
('SVC',	'El Salvador Colon'),
('SYP',	'Syria Pound'),
('SZL',	'Swaziland Lilangeni'),
('TJS',	'Tajikistan Somoni'),
('TMT',	'Turkmenistan Manat'),
('TND',	'Tunisia Dinar'),
('TOP',	'Tonga Pa-anga'),
('TRY',	'Turkey Lira'),
('TTD',	'Trinidad and Tobago Dollar'),
('TVD',	'Tuvalu Dollar'),
('TWD',	'Taiwan New Dollar'),
('TZS',	'Tanzania Shilling'),
('UAH',	'Ukraine Hryvna'),
('UGX',	'Uganda Shilling'),
('UYU',	'Uruguay Peso'),
('UZS',	'Uzbekistan Som'),
('VEF',	'Venezuela Bolivar'),
('VND',	'Viet Nam Dong'),
('VUV',	'Vanuatu Vatu'),
('WST',	'Samoa Tala'),
('XAF',	'Communaut� Financi�re Africaine (BEAC) CFA Franc BEAC'),
('XCD',	'East Caribbean Dollar'),
('XDR',	'International Monetary Fund (IMF) Special Drawing Rights'),
('XOF',	'Communaut� Financi�re Africaine (BCEAO) Franc'),
('XPF',	'Comptoirs Fran�ais du Pacifique (CFP) Franc'),
('YER',	'Yemen Rial'),
('ZAR',	'South Africa Rand'),
('ZMW',	'Zambia Kwacha'),
('ZWD',	'Zimbabwe Dollar');


