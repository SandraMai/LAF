-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2020-06-18 06:15:05.63

-- tables
-- Table: ADMIN
CREATE TABLE ADMIN (
    admin_ID int NOT NULL AUTO_INCREMENT,
    username varchar(20) NOT NULL,
    password varchar(100) NOT NULL,
    CONSTRAINT ADMIN_pk PRIMARY KEY (admin_ID)
);

-- Table: AUCTION
CREATE TABLE AUCTION (
    auction_ID int NOT NULL AUTO_INCREMENT,
    start_date timestamp NOT NULL,
    end_date datetime NOT NULL,
    FOUND_ITEM_AD_found_item_ad_ID int NOT NULL,
    expired int NULL,
    step decimal(10,1) NOT NULL,
    winner_email_sent bool NOT NULL,
    CONSTRAINT AUCTION_pk PRIMARY KEY (auction_ID)
);

-- Table: CATEGORY
CREATE TABLE CATEGORY (
    category_ID int NOT NULL AUTO_INCREMENT,
    category_name varchar(30) NOT NULL,
    CONSTRAINT CATEGORY_pk PRIMARY KEY (category_ID)
);

-- Table: FAQ
CREATE TABLE FAQ (
    faq_ID int NOT NULL AUTO_INCREMENT,
    question varchar(200) NOT NULL,
    answer varchar(1000) NOT NULL,
    deleted bool NOT NULL,
    SECTION_section_ID int NOT NULL,
    CONSTRAINT FAQ_pk PRIMARY KEY (faq_ID)
);

-- Table: FOUND_ITEM_AD
CREATE TABLE FOUND_ITEM_AD (
    found_item_ad_ID int NOT NULL AUTO_INCREMENT,
    description varchar(300) NOT NULL,
    found_date date NOT NULL,
    picture varchar(200) NOT NULL,
    expired int NULL,
    place_found varchar(100) NOT NULL,
    added_timestamp timestamp NOT NULL,
    CATEGORY_category_ID int NOT NULL,
    deleted bool NOT NULL,
    auctioned int NULL,
    STORAGE_PLACE_storage_place_ID int NOT NULL,
    CONSTRAINT FOUND_ITEM_AD_pk PRIMARY KEY (found_item_ad_ID)
);

-- Table: LOST_ITEM_AD
CREATE TABLE LOST_ITEM_AD (
    lost_post_ID int NOT NULL AUTO_INCREMENT,
    email varchar(60) NOT NULL,
    lost_date date NULL,
    lost_place varchar(300) NULL,
    picture varchar(200) NULL,
    CATEGORY_category_ID int NOT NULL,
    description varchar(300) NOT NULL,
    added_date timestamp NOT NULL,
    expired bool NOT NULL,
    deleted bool NOT NULL,
    email_sent bool NOT NULL,
    CONSTRAINT LOST_ITEM_AD_pk PRIMARY KEY (lost_post_ID)
);

-- Table: OFFER
CREATE TABLE OFFER (
    offer_ID int NOT NULL AUTO_INCREMENT,
    email varchar(60) NOT NULL,
    notification bool NOT NULL,
    offer double(100,1) NOT NULL,
    AUCTION_auction_ID int NOT NULL,
    CONSTRAINT OFFER_pk PRIMARY KEY (offer_ID)
);

-- Table: OFFER_CHANGE
CREATE TABLE OFFER_CHANGE (
    offer_change_ID int NOT NULL AUTO_INCREMENT,
    start_price double(100,1) NOT NULL,
    offer_step double(100,1) NOT NULL,
    CONSTRAINT OFFER_CHANGE_pk PRIMARY KEY (offer_change_ID)
);

-- Table: SECTION
CREATE TABLE SECTION (
    section_ID int NOT NULL AUTO_INCREMENT,
    section_name varchar(50) NOT NULL,
    CONSTRAINT SECTION_pk PRIMARY KEY (section_ID)
);

-- Table: STORAGE_PLACE
CREATE TABLE STORAGE_PLACE (
    storage_place_ID int NOT NULL AUTO_INCREMENT,
    storage_place_name varchar(40) NOT NULL,
    phonenr varchar(50) NOT NULL,
    email varchar(60) NOT NULL,
    CONSTRAINT STORAGE_PLACE_pk PRIMARY KEY (storage_place_ID)
);

-- foreign keys
-- Reference: AUCTION_FOUND_ITEM_AD (table: AUCTION)
ALTER TABLE AUCTION ADD CONSTRAINT AUCTION_FOUND_ITEM_AD FOREIGN KEY AUCTION_FOUND_ITEM_AD (FOUND_ITEM_AD_found_item_ad_ID)
    REFERENCES FOUND_ITEM_AD (found_item_ad_ID);

-- Reference: FAQ_SECTION (table: FAQ)
ALTER TABLE FAQ ADD CONSTRAINT FAQ_SECTION FOREIGN KEY FAQ_SECTION (SECTION_section_ID)
    REFERENCES SECTION (section_ID);

-- Reference: FOUND_ITEM_AD_CATEGORY (table: FOUND_ITEM_AD)
ALTER TABLE FOUND_ITEM_AD ADD CONSTRAINT FOUND_ITEM_AD_CATEGORY FOREIGN KEY FOUND_ITEM_AD_CATEGORY (CATEGORY_category_ID)
    REFERENCES CATEGORY (category_ID);

-- Reference: FOUND_ITEM_AD_STORAGE_PLACE (table: FOUND_ITEM_AD)
ALTER TABLE FOUND_ITEM_AD ADD CONSTRAINT FOUND_ITEM_AD_STORAGE_PLACE FOREIGN KEY FOUND_ITEM_AD_STORAGE_PLACE (STORAGE_PLACE_storage_place_ID)
    REFERENCES STORAGE_PLACE (storage_place_ID);

-- Reference: LOST_ITEM_AD_CATEGORY (table: LOST_ITEM_AD)
ALTER TABLE LOST_ITEM_AD ADD CONSTRAINT LOST_ITEM_AD_CATEGORY FOREIGN KEY LOST_ITEM_AD_CATEGORY (CATEGORY_category_ID)
    REFERENCES CATEGORY (category_ID);

-- Reference: OFFER_AUCTION (table: OFFER)
ALTER TABLE OFFER ADD CONSTRAINT OFFER_AUCTION FOREIGN KEY OFFER_AUCTION (AUCTION_auction_ID)
    REFERENCES AUCTION (auction_ID);

-- End of file.

