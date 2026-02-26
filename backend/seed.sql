-- ============================================================
--  NSLS — Database Seed
--  Run: mysql -u root nsls_db < backend/seed.sql
-- ============================================================

USE nsls_db;

-- Clear existing data (safe re-run)
TRUNCATE TABLE offices;
TRUNCATE TABLE downloads;

-- ============================================================
--  OFFICES
-- ============================================================
INSERT INTO offices (name, type, address, phone, fax, email, latitude, longitude) VALUES

-- Head Office
('Port Moresby (Head Office)', 'head_office',
 'NSLS Haus, Aopi Centre, Tower 2, Level 1, Waigani Drive',
 '180 1599', NULL,
 'NSLSonlineservices@nambawansuper.com.pg',
 -9.4438, 147.1803),

-- Branches
('Alotau', 'branch',
 'Ground Floor Chascorp Building, Sec 21 Lot 10, P.O Box 272, Milne Bay',
 '641 0671', '641 0587',
 'nsls@nambawansuper.com.pg',
 -10.3167, 150.4500),

('Buka', 'branch',
 'Suite 2 Level 1, Go Well Holdings Ltd, P.O Box 19, Buka',
 '973 9802', '973 9820',
 'nsls@nambawansuper.com.pg',
 -5.4215, 154.6730),

('Goroka', 'branch',
 'Henganofi Development Cooperation Building, P.O Box 757, Goroka, E.H.P',
 '532 1224', '532 1918',
 'nsls@nambawansuper.com.pg',
 -6.0833, 145.3833),

('Kavieng', 'branch',
 'Ground Floor Unit 1 North Cape Building, Nusa Parade, P.O Box 567, New Ireland',
 '984 2611', '984 2612',
 'nsls@nambawansuper.com.pg',
 -2.5744, 150.7964),

('Kimbe', 'branch',
 'Level 1 Hamamas Trading, Kisere, P.O Box 593, West New Britain',
 '983 5450', '983 5150',
 'nsls@nambawansuper.com.pg',
 -5.5500, 150.1333),

('Kiunga', 'branch',
 'Ground Floor Kiunga Corporative Company Building, P.O Box 373, W.P',
 '649 1744', '649 1331',
 'nsls@nambawansuper.com.pg',
 -6.1167, 141.3000),

('Kokopo', 'branch',
 'PNG Motors Complex, Level 1 Williams Road, P.O Box 608, E.N.B',
 '982 8900', '982 8901',
 'nsls@nambawansuper.com.pg',
 -4.3500, 152.2667),

('Lae', 'branch',
 'Nambawan Super Haus (Formerly IPI Building), P.O Box 1289, Morobe Province',
 '472 2272', '474 4536',
 'nsls@nambawansuper.com.pg',
 -6.7333, 147.0000),

('Mt. Hagen', 'branch',
 'Suite 1 Gapina Building Hagen Drive, P.O Box 1574, W.H.P',
 '542 1182', '542 1186',
 'nsls@nambawansuper.com.pg',
 -5.8500, 144.2167),

('Madang', 'branch',
 'Suite 7 Level 1, ANZ Building Modilon Road, P.O Box 142, Madang',
 '422 0244', '422 0255',
 'nsls@nambawansuper.com.pg',
 -5.2167, 145.8000),

('Kundiawa', 'branch',
 'Community Development Building, P.O Box 223, Kundiawa',
 '535 1600', NULL,
 'nsls@nambawansuper.com.pg',
 -6.0167, 144.9667),

('Manus', 'branch',
 'Handyman & Hardware Building, P.O Box 39, Lorengau',
 '970 9530', '970 9552',
 'nsls@nambawansuper.com.pg',
 -2.0218, 147.2706),

('Mendi', 'branch',
 'Suite 1 Level 1, Kima Building, Genda Crescant, P.O Box 243, S.H.P',
 '549 2549', '549 2459',
 'nsls@nambawansuper.com.pg',
 -6.1500, 143.6500),

('Popondetta', 'branch',
 'Opic Building, P.O Box 87, Oro Province',
 '629 7870', '629 7818',
 'nsls@nambawansuper.com.pg',
 -8.7578, 148.2336),

('Vanimo', 'branch',
 'Room 2, MRA Building, P.O Box 416, W.S.P',
 '457 0110', '457 0111',
 'nsls@nambawansuper.com.pg',
 -2.6833, 141.3000),

('Wabag', 'branch',
 'P.O Box 85, Wabag',
 '547 1316', '547 1415',
 'nsls@nambawansuper.com.pg',
 -5.4833, 143.7167),

('Wewak', 'branch',
 'Room 14 Level 1, Neenera Building, Cathedral Road, P.O Box 1084, E.S.P',
 NULL, NULL,
 'nsls@nambawansuper.com.pg',
 -3.5500, 143.6333);

-- ============================================================
--  DOWNLOADS — Member Forms
-- ============================================================
INSERT INTO downloads (title, category, file_path, file_size) VALUES

('Company Fact Sheet',            'form', 'downloads/forms/company-fact-sheet.pdf',            '1.1MB'),
('New Membership Form',           'form', 'downloads/forms/new-membership-form.pdf',           '1.2MB'),
('Member Detail Update Form',     'form', 'downloads/forms/member-detail-update-form.pdf',     '800KB'),
('IATD Form Main',                'form', 'downloads/forms/iatd-form-main.pdf',                '900KB'),
('Pikinini Saver New Member Form','form', 'downloads/forms/pikinini-saver-new-member-form.pdf','1.5MB'),
('Loan Advance / Application Form','form','downloads/forms/loan-advance-application-form.pdf', '2.1MB'),
('1:2 Unsecured Loan Application Form','form','downloads/forms/1-2-unsecured-loan-application-form.pdf','1.4MB'),
('1:5 Unsecured Loan Application Form','form','downloads/forms/1-5-unsecured-loan-application-form.pdf','1.6MB'),
('1:2 Teachers Loan Agreement Form','form','downloads/forms/1-2-teachers-loan-agreement-form.pdf','1.3MB'),
('1-2 Loan Schedule',             'form', 'downloads/forms/1-2-loan-schedule.pdf',             '700KB'),
('Withdrawal Application Form',   'form', 'downloads/forms/withdrawal-application-form.pdf',   '1.1MB'),

-- ============================================================
--  DOWNLOADS — Brochures
-- ============================================================
('Tertiary Education Saver',   'brochure', 'downloads/brochures/tertiary-education-saver.pdf', '2.4MB'),
('Housing Saver',              'brochure', 'downloads/brochures/housing-saver.pdf',             '3.1MB'),
('Pikinini Saver',             'brochure', 'downloads/brochures/pikinini-saver.pdf',            '2.8MB'),
('1:1 Loan Package',           'brochure', 'downloads/brochures/1-1-loan-package.pdf',          '1.9MB'),
('1:2 Loan Package',           'brochure', 'downloads/brochures/1-2-loan-package.pdf',          '2.1MB'),
('1.5 Brochure & FAQ',         'brochure', 'downloads/brochures/1-5-brochure-faq.pdf',          '2.5MB'),
('NSLS Loan Products',         'brochure', 'downloads/brochures/nsls-loan-products.pdf',        '3.8MB'),
('NSLS Savings Products',      'brochure', 'downloads/brochures/nsls-savings-products.pdf',     '3.2MB'),
('NSLS Services',              'brochure', 'downloads/brochures/nsls-services.pdf',             '2.9MB');
