SELECT * FROM `pre_moodwall` ORDER BY id desc limit 10		//反向查询 最新
TRUNCATE TABLE ssqdata
DELETE FROM table1 where id=1





CREATE TABLE `userinput` (
`inputId` int(11) NOT NULL AUTO_INCREMENT,
`userId` varchar(255) CHARACTER SET utf8 NOT NULL,
`mode` varchar(255) NOT NULL DEFAULT 'NORMAL',
`input` varchar(255) CHARACTER SET utf8 NOT NULL,
`addTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(`inputId`)
);
CREATE TABLE `picindex`(
`userName` varchar(255) NOT NULL,
`cur` int(11) NOT NULL DEFAULT '1',
`limited` int(11) NOT NULL DEFAULT '1',
`quota` int(11) NOT NULL DEFAULT '1',
`seenPic` int (11) NOT NULL DEFAULT '0',
`lastSeen` int (11) NOT NULL DEFAULT '0',
`addTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

create table cUser(
userId varchar(255) NOT NULL,
password varchar(255) NOT NULL,
email varchar(255),
money bigint(20) default 0,
bulletNum bigint(20) default 0 COMMENT 'nums',
xsft bigint(20)	default 0 	COMMENT 'xsft',
hdcx bigint(20) default 0	COMMENT 'hdcx',
chxs bigint(20) default 0	COMMENT 'chxs',
sszm bigint(20) default 0	COMMENT 'sszm',
win	 bigint(20) default 0	COMMENT 'win times',
loss bigint(20) default 0	COMMENT 'loss times',
`modeTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
`addTimestamp` timestamp NOT NULL,
primary key(userId)
);

create table cWaitingUser
(
	userId varchar(255) NOT NULL,
	`addTimestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
	primary key(userId),
	foreign key(userId) references cUser(userId)
	);
create table cFight
(
fightId bigint(20) NOT NULL AUTO_INCREMENT,
user1 varchar(255) NOT NULL,
user2 varchar(255) NOT NULL,
magic1 varchar(255) NOT NULL COMMENT 'user1 magic',
magic2 varchar (255) NOT NULL COMMENT 'usr2 magic',
gameNumber int default 0 COMMENT 'ROUND nums',
first	varchar(255) NOT NULL COMMENT 'this game who doing first',
current varchar(255) NOT NULL COMMENT '	this round who doing first',
operation varchar(255) NOT NULL COMMENT 'opertaion',
operator	varchar(255) NOT NULL  COMMENT 'operator',
msgForOther varchar(255) COMMENT 'give other message',
otherId		varchar(255) COMMENT 'other id',
money	bigint(20)	NOT NULL COMMENT 'the whole money',
minMoney bigint(20) NOT NULL COMMENT 'the mini money',
maxMoney bigint(20) NOT NULL COMMENT 'the max money',
count int COMMENT 'the bullet hole nums ,',
historyOp varchar(4096) NOT NULL COMMENT 'operation history',
magicUsed1 varchar(255) COMMENT 'user1 used magic',
magicUser2 varchar(255) COMMENT 'user2 used magic',
lastInfo TEXT COMMENT 'the last gun status',
loss1	varchar(255) default 0 COMMENT 'the first winner',
loss2	varchar(255) default 0 COMMENT 'the second winner',
`addTimestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
primary key(fightId),
foreign key(user1) references cUser(userId),
foreign key(user2) references cUser(userId)
);
 SELECT * FROM ssqdata WHERE 1 AND `Num` > '350'
DELETE FROM lostrtable WHERE id >350

	CREATE TABLE `ssqdata` (
	`id` int(11) NOT NULL ,
	`Num` int(11) NOT NULL ,
	`R1` int(11) NOT NULL ,
	`R2` int(11) NOT NULL ,
	`R3` int(11) NOT NULL ,
	`R4` int(11) NOT NULL ,
	`R5` int(11) NOT NULL ,
	`R6` int(11) NOT NULL ,
	`B1` int(11) NOT NULL ,
	`addTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	);
			
CREATE TABLE lostRTable(
	 id int(11) NOT NULL ,
	 Num int(11) NOT NULL,
	 RL1 int(3) NOT NULL,
	 RL2 int(3) NOT NULL,
	 RL3 int(3) NOT NULL,
	 RL4 int(3) NOT NULL,
	 RL5 int(3) NOT NULL,
	 RL6 int(3) NOT NULL,
	 RL7 int(3) NOT NULL,
	 RL8 int(3) NOT NULL,
	 RL9 int(3) NOT NULL,
	 RL10 int(3) NOT NULL,
	 RL11 int(3) NOT NULL,
	 RL12 int(3) NOT NULL,
	 RL13 int(3) NOT NULL,
	 RL14 int(3) NOT NULL,
	 RL15 int(3) NOT NULL,
	 RL16 int(3) NOT NULL,
	 RL17 int(3) NOT NULL,
	 RL18 int(3) NOT NULL,
	 RL19 int(3) NOT NULL,
	 RL20 int(3) NOT NULL,
	 RL21 int(3) NOT NULL,
	 RL22 int(3) NOT NULL,
	 RL23 int(3) NOT NULL,
	 RL24 int(3) NOT NULL,
	 RL25 int(3) NOT NULL,
	 RL26 int(3) NOT NULL,
	 RL27 int(3) NOT NULL,
	 RL28 int(3) NOT NULL,
	 RL29 int(3) NOT NULL,
	 RL30 int(3) NOT NULL,
	 RL31 int(3) NOT NULL,
	 RL32 int(3) NOT NULL,
	 RL33 int(3) NOT NULL,
);
CREATE TABLE lostBTable(
	 id int(11) NOT NULL AUTO_INCREMENT,
	 Num int(11) NOT NULL,
	 BL1 int(3) NOT NULL,
	 BL2 int(3) NOT NULL,
	 BL3 int(3) NOT NULL,
	 BL4 int(3) NOT NULL,
	 BL5 int(3) NOT NULL,
	 BL6 int(3) NOT NULL,
	 BL7 int(3) NOT NULL,
	 BL8 int(3) NOT NULL,
	 BL9 int(3) NOT NULL,
	 BL10 int(3) NOT NULL,
	 BL11 int(3) NOT NULL,
	 BL12 int(3) NOT NULL,
	 BL13 int(3) NOT NULL,
	 BL14 int(3) NOT NULL,
	 BL15 int(3) NOT NULL,
	 BL16 int(3) NOT NULL,
	 DIF  int(3) NOT NULL

	PRIMARY KEY(`id`)
);


