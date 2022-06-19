CREATE DATABASE criminaloccurence;

CREATE TABLE
  `test` (
    `id` varchar(80) NOT NULL,
    `name` varchar(80) NOT NULL,
    `email` varchar(80) NOT NULL,
    `password` text NOT NULL,
    `image_dir` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = latin1
  
  