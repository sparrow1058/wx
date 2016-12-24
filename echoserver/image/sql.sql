CREATE TABLE `userinput` (
`inputId` int(11) NOT NULL AUTO_INCREMENT,
`userId` varchar(255) CHARACTER SET utf8 NOT NULL,
`mode` varchar(255) NOT NULL DEFAULT 'NORMAL',
`input` varchar(255) CHARACTER SET utf8 NOT NULL,
`addTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(`inputId`)
);