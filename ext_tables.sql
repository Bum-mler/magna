-- 
-- Table structure for table 'pages' = type 169
-- 
CREATE TABLE pages (
	
	rocktype varchar(255) DEFAULT '' NOT NULL,
	subgroup varchar(255) DEFAULT '' NOT NULL,
	age varchar(255) DEFAULT '' NOT NULL,
	origin varchar(255) DEFAULT '' NOT NULL,
	color int(11) DEFAULT '0' NOT NULL,
	structure int(11) DEFAULT '0' NOT NULL,

	indoordry_1 int(11) DEFAULT '0' NOT NULL,
	indoordry_2 int(11) DEFAULT '0' NOT NULL,
	indoordry_3 int(11) DEFAULT '0' NOT NULL,
	indoordry_4 int(11) DEFAULT '0' NOT NULL,
	indoordry_5 int(11) DEFAULT '0' NOT NULL,

	indoorwet_1 int(11) DEFAULT '0' NOT NULL,
	indoorwet_2 int(11) DEFAULT '0' NOT NULL,
	indoorwet_3 int(11) DEFAULT '0' NOT NULL,

	outdoor_1 int(11) DEFAULT '0' NOT NULL,
	outdoor_2 int(11) DEFAULT '0' NOT NULL,
	outdoor_3 int(11) DEFAULT '0' NOT NULL
	
);
