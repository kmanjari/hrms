--
--
-- SQLite3 tables used to run the Editor examples.
--
-- For more information about how the client and server-sides interact, please
-- refer to the Editor documentation: http://editor.datatables.net/manual .
--
--

--
-- To do list examples
--
DROP TABLE IF EXISTS todo;

CREATE TABLE todo (
    id integer primary key,
    item text NOT NULL default '',
    done boolean NOT NULL default '0',
    priority integer NOT NULL default 1
);

INSERT INTO todo (item, done, priority)
    VALUES
        ( 'Send business plan to clients', 1, 1 ),
        ( 'Web-site copy revisions',       0, 2 ),
        ( 'Review client tracking',        0, 2 ),
        ( 'E-mail catchup',                0, 3 ),
        ( 'Complete worksheet',            0, 4 ),
        ( 'Prep sales presentation',       0, 5 );


--
-- Users table examples
--
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS dept;
DROP TABLE IF EXISTS access;
DROP TABLE IF EXISTS sites;

DROP TABLE IF EXISTS user_dept;
DROP TABLE IF EXISTS user_access;

CREATE TABLE users (
    id integer primary key, 
    title text default NULL,
    first_name text default NULL,
    last_name text default NULL,
    phone text default NULL,
    city text default NULL,
    zip text default NULL,
    updated_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    registered_date timestamp without time zone,
    active boolean default NULL,
    comments text default NULL,
    manager int default NULL,
    site int default NULL
); 

CREATE TRIGGER [UpdateLastTime]
AFTER UPDATE ON users
BEGIN
    UPDATE users SET updated_date = CURRENT_TIMESTAMP WHERE id = old.id;
END;



CREATE TABLE dept (
    id integer primary key, 
    name text default NULL
);

CREATE TABLE access (
    id integer primary key,  
    name text default NULL
);

CREATE TABLE sites (
    id integer primary key,  
    name text default NULL
);



-- Expect only one dept per user
CREATE TABLE user_dept (
    user_id int,
    dept_id int,
    PRIMARY KEY (user_id, dept_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (dept_id) REFERENCES dept(id) ON DELETE CASCADE
);

-- Expect multiple access per user
CREATE TABLE user_access (
    user_id int,
    access_id int,
    PRIMARY KEY (user_id, access_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (access_id) REFERENCES access(id) ON DELETE CASCADE
);


INSERT INTO users (title, first_name, last_name, phone, city, zip, registered_date, active, manager, site)
    VALUES
        ('Miss','Quynn',     'Contreras',    '1-971-977-4681', 'Slidell',               '81080',    '2012-04-06 18:53:00', '0', 1, 1),
        ('Mr',  'Kaitlin',   'Smith',        '1-436-523-6103', 'Orlando',               'U5G 7J3',  '2012-11-20 05:58:25', '1', 1, 2),
        ('Mrs', 'Cruz',      'Reynolds',     '1-776-102-6352', 'Lynn',                  'EJ89 9DQ', '2011-12-31 23:34:03', '0', 2, 3),
        ('Dr',  'Sophia',    'Morris',       '1-463-224-1405', 'Belleville',            'T1F 2X1',  '2012-08-04 02:55:53', '0', 3, 4),
        ('Miss','Kamal',     'Roberson',     '1-134-408-5227', 'Rehoboth Beach',        'V7I 6T5',  '2012-12-23 00:17:03', '1', 1, 5),
        ('Dr',  'Dustin',    'Rosa',         '1-875-919-3188', 'Jersey City',           'E4 8ZE',   '2012-10-05 22:18:59', '0', 1, 6),
        ('Dr',  'Xantha',    'George',       '1-106-884-4754', 'Billings',              'Y2I 6J7',  '2012-11-25 12:50:16', '0', 6, 1),
        ('Mrs', 'Bryar',     'Long',         '1-918-114-8083', 'San Bernardino',        '82983',    '2012-05-14 23:32:25', '0', 1, 2),
        ('Mrs', 'Kuame',     'Wynn',         '1-101-692-4039', 'Truth or Consequences', '21290',    '2011-06-21 16:27:07', '1', 2, 3),
        ('Ms',  'Indigo',    'Brennan',      '1-756-756-8161', 'Moline',                'NO8 3UY',  '2011-02-19 12:51:08', '1', 5, 4),
        ('Mrs', 'Avram',     'Allison',      '1-751-507-2640', 'Rancho Palos Verdes',   'I7Q 8H4',  '2012-12-30 17:02:10', '0', 1, 5),
        ('Mr',  'Martha',    'Burgess',      '1-971-722-1203', 'Toledo',                'Q5R 9HI',  '2011-02-04 17:25:55', '1', 1, 6),
        ('Miss','Lael',      'Kim',          '1-626-697-2194', 'Lake Charles',          '34209',    '2012-07-24 06:44:22', '1', 7, 1),
        ('Dr',  'Lyle',      'Lewis',        '1-231-793-3520', 'Simi Valley',           'H9B 2H4',  '2012-08-30 03:28:54', '0', 1, 2),
        ('Miss','Veronica',  'Marks',        '1-750-981-6759', 'Glens Falls',           'E3C 5D1',  '2012-08-14 12:09:24', '1', 2, 3),
        ('Mrs', 'Wynne',     'Ruiz',         '1-983-744-5362', 'Branson',               'L9E 6E2',  '2012-11-06 01:04:07', '0', 1, 4),
        ('Ms',  'Jessica',   'Bryan',        '1-949-932-6772', 'Boulder City',          'F5P 6NU',  '2013-02-01 20:22:33', '0', 5, 5),
        ('Ms',  'Quinlan',   'Hyde',         '1-625-664-6072', 'Sheridan',              'Y8A 1LQ',  '2011-10-25 16:53:45', '1', 1, 6),
        ('Miss','Mona',      'Terry',        '1-443-179-7343', 'Juneau',                'G62 1OF',  '2012-01-15 09:26:59', '0', 1, 1),
        ('Mrs', 'Medge',     'Patterson',    '1-636-979-0497', 'Texarkana',             'I5U 6E0',  '2012-10-20 16:26:18', '1', 1, 2),
        ('Mrs', 'Perry',     'Gamble',       '1-440-976-9560', 'Arcadia',               '98923',    '2012-06-06 02:03:49', '1', 2, 3),
        ('Mrs', 'Pandora',   'Armstrong',    '1-197-431-4390', 'Glendora',              '34124',    '2011-08-29 01:45:06', '0', 7, 4),
        ('Mr',  'Pandora',   'Briggs',       '1-278-288-9221', 'Oneida',                'T9M 4H9',  '2012-07-16 08:44:41', '1', 4, 5),
        ('Mrs', 'Maris',     'Leblanc',      '1-936-114-2921', 'Cohoes',                'V1H 6Z7',  '2011-05-04 13:07:04', '1', 1, 6),
        ('Mrs', 'Ishmael',   'Crosby',       '1-307-243-2684', 'Midwest City',          'T6 8PS',   '2011-07-02 23:11:11', '0', 3, 1),
        ('Miss','Quintessa', 'Pickett',      '1-801-122-7471', 'North Tonawanda',       '09166',    '2013-02-05 10:33:22', '1', 1, 2),
        ('Miss','Ifeoma',    'Mays',         '1-103-883-0962', 'Parkersburg',           '87377',    '2011-08-22 12:19:09', '0', 1, 3),
        ('Mrs', 'Basia',     'Harrell',      '1-528-238-4178', 'Cody',                  'LJ54 1IU', '2012-05-07 14:42:55', '1', 1, 4),
        ('Mrs', 'Hamilton',  'Blackburn',    '1-676-857-1423', 'Delta Junction',        'X5 9HE',   '2011-05-19 07:39:48', '0', 6, 5),
        ('Ms',  'Dexter',    'Burton',       '1-275-332-8186', 'Gainesville',           '65914',    '2013-02-01 16:21:20', '1', 5, 6),
        ('Mrs', 'Quinn',     'Mccall',       '1-808-916-4497', 'Fallon',                'X4 8UB',   '2012-03-24 19:31:51', '0', 1, 1),
        ('Mr',  'Alexa',     'Wilder',       '1-727-307-1997', 'Johnson City',          '16765',    '2011-10-14 08:21:14', '0', 3, 2),
        ('Ms',  'Rhonda',    'Harrell',      '1-934-906-6474', 'Minnetonka',            'I2R 1H2',  '2011-11-15 00:08:02', '1', 1, 3),
        ('Mrs', 'Jocelyn',   'England',      '1-826-860-7773', 'Chico',                 '71102',    '2012-05-31 18:01:43', '1', 1, 4),
        ('Dr',  'Vincent',   'Banks',        '1-225-418-0941', 'Palo Alto',             '03281',    '2011-08-07 07:22:43', '0', 1, 5),
        ('Mrs', 'Stewart',   'Chan',         '1-781-793-2340', 'Grand Forks',           'L1U 3ED',  '2012-11-01 23:14:44', '1', 6, 6);

INSERT INTO dept (name)
    VALUES
        ( 'IT' ),
        ( 'Sales' ),
        ( 'Pre-Sales' ),
        ( 'Marketing' ),
        ( 'Senior Management' ),
        ( 'Accounts' ),
        ( 'Support' );

INSERT INTO access (name)
    VALUES
        ( 'Printer' ),
        ( 'Servers' ),
        ( 'Desktop' ),
        ( 'VMs' ),
        ( 'Web-site' ),
        ( 'Accounts' );


INSERT INTO user_dept (user_id, dept_id)
    VALUES
        ( 1,  1 ),
        ( 2,  4 ),
        ( 3,  7 ),
        ( 4,  3 ),
        ( 5,  2 ),
        ( 6,  6 ),
        ( 7,  2 ),
        ( 8,  1 ),
        ( 9,  2 ),
        ( 10, 3 ),
        ( 11, 4 ),
        ( 12, 5 ),
        ( 13, 6 ),
        ( 14, 4 ),
        ( 15, 3 ),
        ( 16, 6 ),
        ( 17, 3 ),
        ( 18, 7 ),
        ( 19, 7 ),
        ( 20, 1 ),
        ( 21, 2 ),
        ( 22, 6 ),
        ( 23, 3 ),
        ( 24, 4 ),
        ( 25, 5 ),
        ( 26, 6 ),
        ( 27, 7 ),
        ( 28, 2 ),
        ( 29, 3 ),
        ( 30, 1 ),
        ( 31, 3 ),
        ( 32, 4 ),
        ( 33, 6 ),
        ( 34, 7 ),
        ( 35, 2 ),
        ( 36, 3 );


INSERT INTO user_access (user_id, access_id)
    VALUES
        ( 1,  1 ),
        ( 1,  3 ),
        ( 1,  4 ),
        ( 2,  4 ),
        ( 2,  1 ),
        ( 4,  3 ),
        ( 4,  4 ),
        ( 4,  5 ),
        ( 4,  6 ),
        ( 5,  2 ),
        ( 6,  6 ),
        ( 7,  2 ),
        ( 8,  1 ),
        ( 9,  2 ),
        ( 10, 3 ),
        ( 10, 2 ),
        ( 10, 1 ),
        ( 11, 4 ),
        ( 11, 6 ),
        ( 12, 5 ),
        ( 12, 1 ),
        ( 12, 2 ),
        ( 13, 1 ),
        ( 13, 2 ),
        ( 13, 3 ),
        ( 13, 6 ),
        ( 18, 3 ),
        ( 18, 2 ),
        ( 18, 1 ),
        ( 20, 1 ),
        ( 20, 2 ),
        ( 20, 3 ),
        ( 21, 2 ),
        ( 21, 4 ),
        ( 22, 6 ),
        ( 22, 3 ),
        ( 22, 2 ),
        ( 30, 1 ),
        ( 30, 5 ),
        ( 30, 3 ),
        ( 31, 3 ),
        ( 32, 4 ),
        ( 33, 6 ),
        ( 34, 1 ),
        ( 34, 2 ),
        ( 34, 3 ),
        ( 35, 2 ),
        ( 36, 3 );

INSERT INTO sites (name)
    VALUES
        ( 'Edinburgh' ),
        ( 'London' ),
        ( 'Paris' ),
        ( 'New York' ),
        ( 'Singapore' ),
        ( 'Los Angeles' );


--
-- DataTables Ajax and server-side processing database (SQLite)
--
DROP TABLE IF EXISTS datatables_demo;

CREATE TABLE datatables_demo (
	id         integer primary key,
	first_name text NOT NULL default '',
	last_name  text NOT NULL default '',
	position   text NOT NULL default '',
	email      text NOT NULL default '',
	office     text NOT NULL default '',
	start_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
	age        integer,
	salary     integer,
	extn       text NOT NULL default ''
);

INSERT INTO datatables_demo
		( id, first_name, last_name, age, position, salary, start_date, extn, email, office ) 
	VALUES
		( 1, 'Tiger', 'Nixon', 61, 'System Architect', 320800, '2011/04/25', 5421, 't.nixon@datatables.net', 'Edinburgh' ),
		( 2, 'Garrett', 'Winters', 63, 'Accountant', 170750, '2011/07/25', 8422, 'g.winters@datatables.net', 'Tokyo' ),
		( 3, 'Ashton', 'Cox', 66, 'Junior Technical Author', 86000, '2009/01/12', 1562, 'a.cox@datatables.net', 'San Francisco' ),
		( 4, 'Cedric', 'Kelly', 22, 'Senior Javascript Developer', 433060, '2012/03/29', 6224, 'c.kelly@datatables.net', 'Edinburgh' ),
		( 5, 'Airi', 'Satou', 33, 'Accountant', 162700, '2008/11/28', 5407, 'a.satou@datatables.net', 'Tokyo' ),
		( 6, 'Brielle', 'Williamson', 61, 'Integration Specialist', 372000, '2012/12/02', 4804, 'b.williamson@datatables.net', 'New York' ),
		( 7, 'Herrod', 'Chandler', 59, 'Sales Assistant', 137500, '2012/08/06', 9608, 'h.chandler@datatables.net', 'San Francisco' ),
		( 8, 'Rhona', 'Davidson', 55, 'Integration Specialist', 327900, '2010/10/14', 6200, 'r.davidson@datatables.net', 'Tokyo' ),
		( 9, 'Colleen', 'Hurst', 39, 'Javascript Developer', 205500, '2009/09/15', 2360, 'c.hurst@datatables.net', 'San Francisco' ),
		( 10, 'Sonya', 'Frost', 23, 'Software Engineer', 103600, '2008/12/13', 1667, 's.frost@datatables.net', 'Edinburgh' ),
		( 11, 'Jena', 'Gaines', 30, 'Office Manager', 90560, '2008/12/19', 3814, 'j.gaines@datatables.net', 'London' ),
		( 12, 'Quinn', 'Flynn', 22, 'Support Lead', 342000, '2013/03/03', 9497, 'q.flynn@datatables.net', 'Edinburgh' ),
		( 13, 'Charde', 'Marshall', 36, 'Regional Director', 470600, '2008/10/16', 6741, 'c.marshall@datatables.net', 'San Francisco' ),
		( 14, 'Haley', 'Kennedy', 43, 'Senior Marketing Designer', 313500, '2012/12/18', 3597, 'h.kennedy@datatables.net', 'London' ),
		( 15, 'Tatyana', 'Fitzpatrick', 19, 'Regional Director', 385750, '2010/03/17', 1965, 't.fitzpatrick@datatables.net', 'London' ),
		( 16, 'Genry', 'Silva', 66, 'Marketing Designer', 198500, '2012/11/27', 1581, 'm.silva@datatables.net', 'London' ),
		( 17, 'Paul', 'Byrd', 64, 'Chief Financial Officer (CFO)', 725000, '2010/06/09', 3059, 'p.byrd@datatables.net', 'New York' ),
		( 18, 'Gloria', 'Little', 59, 'Systems Administrator', 237500, '2009/04/10', 1721, 'g.little@datatables.net', 'New York' ),
		( 19, 'Bradley', 'Greer', 41, 'Software Engineer', 132000, '2012/10/13', 2558, 'b.greer@datatables.net', 'London' ),
		( 20, 'Dai', 'Rios', 35, 'Personnel Lead', 217500, '2012/09/26', 2290, 'd.rios@datatables.net', 'Edinburgh' ),
		( 21, 'Jenette', 'Caldwell', 30, 'Development Lead', 345000, '2011/09/03', 1937, 'j.caldwell@datatables.net', 'New York' ),
		( 22, 'Yuri', 'Berry', 40, 'Chief Marketing Officer (CMO)', 675000, '2009/06/25', 6154, 'y.berry@datatables.net', 'New York' ),
		( 23, 'Caesar', 'Vance', 21, 'Pre-Sales Support', 106450, '2011/12/12', 8330, 'c.vance@datatables.net', 'New York' ),
		( 24, 'Doris', 'Wilder', 23, 'Sales Assistant', 85600, '2010/09/20', 3023, 'd.wilder@datatables.net', 'Sidney' ),
		( 25, 'Angelica', 'Ramos', 47, 'Chief Executive Officer (CEO)', 1200000, '2009/10/09', 5797, 'a.ramos@datatables.net', 'London' ),
		( 26, 'Gavin', 'Joyce', 42, 'Developer', 92575, '2010/12/22', 8822, 'g.joyce@datatables.net', 'Edinburgh' ),
		( 27, 'Jennifer', 'Chang', 28, 'Regional Director', 357650, '2010/11/14', 9239, 'j.chang@datatables.net', 'Singapore' ),
		( 28, 'Brenden', 'Wagner', 28, 'Software Engineer', 206850, '2011/06/07', 1314, 'b.wagner@datatables.net', 'San Francisco' ),
		( 29, 'Fiona', 'Green', 48, 'Chief Operating Officer (COO)', 850000, '2010/03/11', 2947, 'f.green@datatables.net', 'San Francisco' ),
		( 30, 'Shou', 'Itou', 20, 'Regional Marketing', 163000, '2011/08/14', 8899, 's.itou@datatables.net', 'Tokyo' ),
		( 31, 'Michelle', 'House', 37, 'Integration Specialist', 95400, '2011/06/02', 2769, 'm.house@datatables.net', 'Sidney' ),
		( 32, 'Suki', 'Burks', 53, 'Developer', 114500, '2009/10/22', 6832, 's.burks@datatables.net', 'London' ),
		( 33, 'Prescott', 'Bartlett', 27, 'Technical Author', 145000, '2011/05/07', 3606, 'p.bartlett@datatables.net', 'London' ),
		( 34, 'Gavin', 'Cortez', 22, 'Team Leader', 235500, '2008/10/26', 2860, 'g.cortez@datatables.net', 'San Francisco' ),
		( 35, 'Martena', 'Mccray', 46, 'Post-Sales support', 324050, '2011/03/09', 8240, 'm.mccray@datatables.net', 'Edinburgh' ),
		( 36, 'Unity', 'Butler', 47, 'Marketing Designer', 85675, '2009/12/09', 5384, 'u.butler@datatables.net', 'San Francisco' ),
		( 37, 'Howard', 'Hatfield', 51, 'Office Manager', 164500, '2008/12/16', 7031, 'h.hatfield@datatables.net', 'San Francisco' ),
		( 38, 'Hope', 'Fuentes', 41, 'Secretary', 109850, '2010/02/12', 6318, 'h.fuentes@datatables.net', 'San Francisco' ),
		( 39, 'Vivian', 'Harrell', 62, 'Financial Controller', 452500, '2009/02/14', 9422, 'v.harrell@datatables.net', 'San Francisco' ),
		( 40, 'Timothy', 'Mooney', 37, 'Office Manager', 136200, '2008/12/11', 7580, 't.mooney@datatables.net', 'London' ),
		( 41, 'Jackson', 'Bradshaw', 65, 'Director', 645750, '2008/09/26', 1042, 'j.bradshaw@datatables.net', 'New York' ),
		( 42, 'Olivia', 'Liang', 64, 'Support Engineer', 234500, '2011/02/03', 2120, 'o.liang@datatables.net', 'Singapore' ),
		( 43, 'Bruno', 'Nash', 38, 'Software Engineer', 163500, '2011/05/03', 6222, 'b.nash@datatables.net', 'London' ),
		( 44, 'Sakura', 'Yamamoto', 37, 'Support Engineer', 139575, '2009/08/19', 9383, 's.yamamoto@datatables.net', 'Tokyo' ),
		( 45, 'Thor', 'Walton', 61, 'Developer', 98540, '2013/08/11', 8327, 't.walton@datatables.net', 'New York' ),
		( 46, 'Finn', 'Camacho', 47, 'Support Engineer', 87500, '2009/07/07', 2927, 'f.camacho@datatables.net', 'San Francisco' ),
		( 47, 'Serge', 'Baldwin', 64, 'Data Coordinator', 138575, '2012/04/09', 8352, 's.baldwin@datatables.net', 'Singapore' ),
		( 48, 'Zenaida', 'Frank', 63, 'Software Engineer', 125250, '2010/01/04', 7439, 'z.frank@datatables.net', 'New York' ),
		( 49, 'Zorita', 'Serrano', 56, 'Software Engineer', 115000, '2012/06/01', 4389, 'z.serrano@datatables.net', 'San Francisco' ),
		( 50, 'Jennifer', 'Acosta', 43, 'Junior Javascript Developer', 75650, '2013/02/01', 3431, 'j.acosta@datatables.net', 'Edinburgh' ),
		( 51, 'Cara', 'Stevens', 46, 'Sales Assistant', 145600, '2011/12/06', 3990, 'c.stevens@datatables.net', 'New York' ),
		( 52, 'Hermione', 'Butler', 47, 'Regional Director', 356250, '2011/03/21', 1016, 'h.butler@datatables.net', 'London' ),
		( 53, 'Lael', 'Greer', 21, 'Systems Administrator', 103500, '2009/02/27', 6733, 'l.greer@datatables.net', 'London' ),
		( 54, 'Jonas', 'Alexander', 30, 'Developer', 86500, '2010/07/14', 8196, 'j.alexander@datatables.net', 'San Francisco' ),
		( 55, 'Shad', 'Decker', 51, 'Regional Director', 183000, '2008/11/13', 6373, 's.decker@datatables.net', 'Edinburgh' ),
		( 56, 'Genry', 'Bruce', 29, 'Javascript Developer', 183000, '2011/06/27', 5384, 'm.bruce@datatables.net', 'Singapore' ),
		( 57, 'Donna', 'Snider', 27, 'Customer Support', 112000, '2011/01/25', 4226, 'd.snider@datatables.net', 'New York' );