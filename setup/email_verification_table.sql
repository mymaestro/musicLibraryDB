-- Modify existing password_reset table to support email verification
-- This is more efficient than creating a separate table

ALTER TABLE `password_reset` 
ADD COLUMN `username` varchar(128) DEFAULT NULL COMMENT 'Username for email verification requests',
ADD COLUMN `name` varchar(255) DEFAULT NULL COMMENT 'Full name for email verification requests',
ADD COLUMN `password_hash` varchar(128) DEFAULT NULL COMMENT 'Hashed password for email verification requests',
ADD COLUMN `request_type` enum('password_reset', 'email_verification') DEFAULT 'password_reset' COMMENT 'Type of request: password reset or email verification';

-- Add index for request_type for better performance
ALTER TABLE `password_reset` 
ADD INDEX `idx_request_type` (`request_type`);
