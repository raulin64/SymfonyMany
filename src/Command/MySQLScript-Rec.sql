show tables;

SET GLOBAL local_infile = 'ON';

load data local infile 'C:/inetpub/wwwroot/movies2/src/Command/Libro1.csv' 
replace into table film2 fields terminated by ';'
optionally enclosed by '\''
lines terminated by '\n'; 
