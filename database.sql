SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE booking (
  booking_id int(11) NOT NULL,
  start_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  end_date datetime NOT NULL,
  extras_price int(11) NOT NULL DEFAULT '0',
  rooms_price int(11) NOT NULL DEFAULT '0',
  total_price int(11) NOT NULL DEFAULT '0',
  paid_date datetime NOT NULL,
  customer_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE customer (
  customer_id int(11) NOT NULL,
  title varchar(10) NOT NULL,
  first_name tinytext NOT NULL,
  last_name tinytext NOT NULL,
  business_name tinytext NOT NULL,
  email_address tinytext NOT NULL,
  phone_number varchar(13) NOT NULL,
  address_line_1 tinytext NOT NULL,
  address_line_2 tinytext NOT NULL,
  town_city tinytext NOT NULL,
  post_code varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE booking
  ADD PRIMARY KEY (booking_id),
  ADD KEY fk_booking_customer (customer_id) USING BTREE;

ALTER TABLE customer
  ADD PRIMARY KEY (customer_id);


ALTER TABLE booking
  MODIFY booking_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE customer
  MODIFY customer_id int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE booking
  ADD CONSTRAINT booking_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (customer_id);
COMMIT;
