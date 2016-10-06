ALTER TABLE patients MODIFY name VARCHAR(255);

ALTER TABLE patients ADD first_name_code VARCHAR(50) AFTER name;

ALTER TABLE patients ADD last_name_code VARCHAR(50) AFTER first_name_code;
