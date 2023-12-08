# Common-Account-System
通用账号系统

## 该内源项目遵循[Read-Me](https://github.com/WZH-Team/Read-Me)

## SQL初始化
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;