-- =====================================================
-- SCHOOL MANAGEMENT SYSTEM - COMPLETE DATABASE SCHEMA
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS `course_enrollments`;
DROP TABLE IF EXISTS `online_courses`;
DROP TABLE IF EXISTS `payrolls`;
DROP TABLE IF EXISTS `staff`;
DROP TABLE IF EXISTS `inventory_transactions`;
DROP TABLE IF EXISTS `inventory_items`;
DROP TABLE IF EXISTS `inventory_categories`;
DROP TABLE IF EXISTS `event_participants`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `hostel_attendance`;
DROP TABLE IF EXISTS `hostel_allocations`;
DROP TABLE IF EXISTS `hostel_rooms`;
DROP TABLE IF EXISTS `hostels`;
DROP TABLE IF EXISTS `student_transport`;
DROP TABLE IF EXISTS `bus_stops`;
DROP TABLE IF EXISTS `buses`;
DROP TABLE IF EXISTS `bus_routes`;
DROP TABLE IF EXISTS `library_settings`;
DROP TABLE IF EXISTS `book_issues`;
DROP TABLE IF EXISTS `books`;
DROP TABLE IF EXISTS `library_categories`;
DROP TABLE IF EXISTS `invoice_items`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `fee_payments`;
DROP TABLE IF EXISTS `fee_structures`;
DROP TABLE IF EXISTS `fee_categories`;
DROP TABLE IF EXISTS `timetables`;
DROP TABLE IF EXISTS `grade_scales`;
DROP TABLE IF EXISTS `report_cards`;
DROP TABLE IF EXISTS `term_summaries`;
DROP TABLE IF EXISTS `term_results`;
DROP TABLE IF EXISTS `ca_scores`;
DROP TABLE IF EXISTS `continuous_assessments`;
DROP TABLE IF EXISTS `exam_results`;
DROP TABLE IF EXISTS `exam_subjects`;
DROP TABLE IF EXISTS `exams`;
DROP TABLE IF EXISTS `exam_types`;
DROP TABLE IF EXISTS `leave_requests`;
DROP TABLE IF EXISTS `teacher_attendance`;
DROP TABLE IF EXISTS `student_attendance`;
DROP TABLE IF EXISTS `teacher_assignments`;
DROP TABLE IF EXISTS `teachers`;
DROP TABLE IF EXISTS `student_promotions`;
DROP TABLE IF EXISTS `student_parents`;
DROP TABLE IF EXISTS `parents`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `syllabus`;
DROP TABLE IF EXISTS `class_subjects`;
DROP TABLE IF EXISTS `subjects`;
DROP TABLE IF EXISTS `sections`;
DROP TABLE IF EXISTS `classes`;
DROP TABLE IF EXISTS `terms`;
DROP TABLE IF EXISTS `academic_years`;
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `model_has_roles`;
DROP TABLE IF EXISTS `role_has_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `schools`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `school_branches`;
DROP TABLE IF EXISTS `student_transfers`;
DROP TABLE IF EXISTS `backups`;
DROP TABLE IF EXISTS `school_settings`;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- 1. CORE SYSTEM TABLES
-- =====================================================

-- 1.1 SCHOOLS TABLE
CREATE TABLE schools (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    logo VARCHAR(255),
    website VARCHAR(255),
    motto VARCHAR(255),
    established_year YEAR,
    slogan VARCHAR(255),
    currency VARCHAR(10) DEFAULT '₦',
    timezone VARCHAR(50) DEFAULT 'Africa/Lagos',
    academic_term ENUM('term', 'semester', 'quarter') DEFAULT 'term',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    settings JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 1.2 SESSIONS TABLE
CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

-- 1.3 USERS TABLE
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    alternative_phone VARCHAR(20),
    address TEXT,
    profile_photo VARCHAR(255),
    language VARCHAR(10) DEFAULT 'en',
    theme VARCHAR(20) DEFAULT 'light',
    two_factor_secret TEXT NULL,
    two_factor_recovery_codes TEXT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE SET NULL,
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_status (status)
);

-- 1.4 ROLES TABLE
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    guard_name VARCHAR(50) DEFAULT 'web',
    school_id BIGINT UNSIGNED,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    UNIQUE KEY unique_role_per_school (name, school_id)
);

-- 1.5 PERMISSIONS TABLE
CREATE TABLE permissions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    guard_name VARCHAR(50) DEFAULT 'web',
    module VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 1.6 ROLE_HAS_PERMISSIONS
CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- 1.7 MODEL_HAS_ROLES
CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 1.8 ACTIVITY LOGS
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    action VARCHAR(255) NOT NULL,
    module VARCHAR(100),
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    old_data JSON,
    new_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_action (user_id, action),
    INDEX idx_created_at (created_at)
);

-- 1.9 CACHE TABLE
CREATE TABLE cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    INDEX cache_expiration_index (expiration)
);

-- 1.10 CACHE LOCKS TABLE
CREATE TABLE cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

-- =====================================================
-- 2. ACADEMIC STRUCTURE TABLES
-- =====================================================

-- 2.1 ACADEMIC YEARS
CREATE TABLE academic_years (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    code VARCHAR(20),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_current BOOLEAN DEFAULT FALSE,
    is_default BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_current (is_current, status)
);

-- 2.2 TERMS
CREATE TABLE terms (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    academic_year_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    sequence INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_current BOOLEAN DEFAULT FALSE,
    mid_term_break_start DATE,
    mid_term_break_end DATE,
    exam_start_date DATE,
    exam_end_date DATE,
    result_date DATE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE,
    INDEX idx_current (is_current, status)
);

-- 2.3 CLASSES
CREATE TABLE classes (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE,
    grade_level INT,
    capacity INT DEFAULT 40,
    class_teacher_id BIGINT UNSIGNED NULL,
    classroom VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_status (status)
);

-- 2.4 SECTIONS
CREATE TABLE sections (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    class_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    code VARCHAR(20),
    capacity INT DEFAULT 40,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- =====================================================
-- 3. SUBJECTS & CURRICULUM TABLES
-- =====================================================

-- 3.1 SUBJECTS
CREATE TABLE subjects (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE,
    category ENUM('core', 'elective', 'vocational', 'extra_curricular') DEFAULT 'core',
    subject_type ENUM('theory', 'practical', 'both') DEFAULT 'theory',
    credit_hours INT DEFAULT 1,
    passing_marks DECIMAL(5,2) DEFAULT 40,
    maximum_marks DECIMAL(5,2) DEFAULT 100,
    minimum_marks DECIMAL(5,2) DEFAULT 0,
    icon VARCHAR(255),
    color VARCHAR(7) DEFAULT '#0d6efd',
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 3.2 CLASS SUBJECTS
CREATE TABLE class_subjects (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED,
    is_compulsory BOOLEAN DEFAULT TRUE,
    total_periods INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    UNIQUE KEY unique_class_subject (class_id, subject_id)
);

-- 3.3 SYLLABUS
CREATE TABLE syllabus (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    class_subject_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    week_number INT NOT NULL,
    topic VARCHAR(255) NOT NULL,
    subtopics JSON,
    learning_objectives TEXT,
    resources JSON,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (class_subject_id) REFERENCES class_subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE
);

-- =====================================================
-- 4. STUDENT MANAGEMENT TABLES
-- =====================================================

-- 4.1 STUDENTS
CREATE TABLE students (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED NOT NULL,
    admission_number VARCHAR(50) UNIQUE NOT NULL,
    admission_date DATE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other') NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NULL,
    religion VARCHAR(50),
    nationality VARCHAR(50) DEFAULT 'Nigerian',
    state_of_origin VARCHAR(50),
    lga VARCHAR(50),
    address TEXT,
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    emergency_contact_relationship VARCHAR(50),
    medical_conditions TEXT,
    allergies TEXT,
    disabilities TEXT,
    current_class_id BIGINT UNSIGNED,
    current_section_id BIGINT UNSIGNED,
    status ENUM('active', 'transferred', 'graduated', 'suspended', 'expelled', 'withdrawn') DEFAULT 'active',
    profile_photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (current_class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (current_section_id) REFERENCES sections(id) ON DELETE SET NULL,
    INDEX idx_admission (admission_number),
    INDEX idx_class (current_class_id),
    INDEX idx_status (status)
);

-- 4.2 PARENTS
CREATE TABLE parents (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    occupation VARCHAR(100),
    relationship ENUM('father', 'mother', 'guardian', 'grandparent', 'other') NOT NULL,
    phone VARCHAR(20),
    alternative_phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    id_card_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 4.3 STUDENT PARENT LINK
CREATE TABLE student_parents (
    student_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NOT NULL,
    is_primary_contact BOOLEAN DEFAULT FALSE,
    can_receive_sms BOOLEAN DEFAULT TRUE,
    can_receive_email BOOLEAN DEFAULT TRUE,
    can_receive_push BOOLEAN DEFAULT TRUE,
    lives_with_student BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, parent_id),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES parents(id) ON DELETE CASCADE
);

-- 4.4 STUDENT PROMOTION HISTORY
CREATE TABLE student_promotions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT UNSIGNED NOT NULL,
    from_class_id BIGINT UNSIGNED NOT NULL,
    to_class_id BIGINT UNSIGNED NOT NULL,
    from_section_id BIGINT UNSIGNED,
    to_section_id BIGINT UNSIGNED,
    academic_year_id BIGINT UNSIGNED NOT NULL,
    promotion_date DATE NOT NULL,
    status ENUM('promoted', 'repeated', 'transferred') NOT NULL,
    remarks TEXT,
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (from_class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (to_class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE
);

-- =====================================================
-- 5. TEACHER MANAGEMENT TABLES
-- =====================================================

-- 5.1 TEACHERS
CREATE TABLE teachers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED NOT NULL,
    staff_id VARCHAR(50) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    qualification VARCHAR(255),
    specialization VARCHAR(100),
    joining_date DATE NOT NULL,
    employment_type ENUM('permanent', 'contract', 'part-time', 'visiting', 'intern') DEFAULT 'permanent',
    subjects_taught JSON,
    salary_grade VARCHAR(20),
    bank_name VARCHAR(100),
    account_number VARCHAR(20),
    account_name VARCHAR(255),
    nok_name VARCHAR(100),
    nok_phone VARCHAR(20),
    nok_relationship VARCHAR(50),
    cv_document VARCHAR(255),
    certificates JSON,
    status ENUM('active', 'inactive', 'on_leave', 'terminated', 'retired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_staff_id (staff_id)
);

-- 5.2 TEACHER ASSIGNMENTS
CREATE TABLE teacher_assignments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    teacher_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    academic_year_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    is_class_teacher BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (teacher_id, class_id, subject_id, term_id)
);

-- =====================================================
-- 6. ATTENDANCE MANAGEMENT TABLES
-- =====================================================

-- 6.1 STUDENT ATTENDANCE
CREATE TABLE student_attendance (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    section_id BIGINT UNSIGNED,
    date DATE NOT NULL,
    status ENUM('present', 'absent', 'late', 'excused', 'holiday', 'sick') DEFAULT 'present',
    check_in_time TIME,
    check_out_time TIME,
    late_minutes INT DEFAULT 0,
    reason TEXT,
    marked_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (marked_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_date (date),
    INDEX idx_student_date (student_id, date),
    INDEX idx_class_date (class_id, date)
);

-- 6.2 TEACHER ATTENDANCE
CREATE TABLE teacher_attendance (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    status ENUM('present', 'absent', 'late', 'excused', 'holiday') DEFAULT 'present',
    check_in_time TIME,
    check_out_time TIME,
    reason TEXT,
    marked_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    INDEX idx_date (date)
);

-- 6.3 LEAVE REQUESTS
CREATE TABLE leave_requests (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    user_type ENUM('teacher', 'staff') NOT NULL,
    leave_type ENUM('annual', 'sick', 'casual', 'study', 'maternity', 'paternity', 'bereavement', 'other') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days INT DEFAULT 0,
    reason TEXT,
    status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
    approved_by BIGINT UNSIGNED,
    approved_at TIMESTAMP NULL,
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status_date (status, start_date)
);

-- =====================================================
-- 7. EXAMINATION & ASSESSMENT TABLES
-- =====================================================

-- 7.1 EXAM TYPES
CREATE TABLE exam_types (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20),
    weight_percentage DECIMAL(5,2) NOT NULL,
    description TEXT,
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 7.2 EXAMS
CREATE TABLE exams (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    exam_type_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) UNIQUE,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_marks DECIMAL(10,2) DEFAULT 100,
    passing_marks DECIMAL(10,2) DEFAULT 40,
    is_published BOOLEAN DEFAULT FALSE,
    publish_results BOOLEAN DEFAULT FALSE,
    results_published_at TIMESTAMP NULL,
    status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_type_id) REFERENCES exam_types(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE
);

-- 7.3 EXAM SUBJECTS
CREATE TABLE exam_subjects (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    exam_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    total_marks DECIMAL(10,2) NOT NULL,
    passing_marks DECIMAL(10,2),
    duration_minutes INT DEFAULT 60,
    exam_date DATE,
    start_time TIME,
    end_time TIME,
    venue VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_exam_subject (exam_id, subject_id, class_id)
);

-- 7.4 EXAM RESULTS
CREATE TABLE exam_results (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    exam_id BIGINT UNSIGNED NOT NULL,
    exam_subject_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    marks_obtained DECIMAL(10,2) NOT NULL,
    total_marks DECIMAL(10,2) NOT NULL,
    percentage DECIMAL(5,2) DEFAULT 0,
    grade VARCHAR(2),
    grade_point DECIMAL(3,2),
    remarks TEXT,
    position INT,
    entered_by BIGINT UNSIGNED NOT NULL,
    entered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_by BIGINT UNSIGNED,
    approved_at TIMESTAMP NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    INDEX idx_student (student_id),
    INDEX idx_exam (exam_id),
    INDEX idx_subject (exam_subject_id),
    UNIQUE KEY unique_result (exam_subject_id, student_id),
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_subject_id) REFERENCES exam_subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- 7.5 CONTINUOUS ASSESSMENTS
CREATE TABLE continuous_assessments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    class_subject_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    type ENUM('test', 'quiz', 'assignment', 'project', 'homework', 'presentation') DEFAULT 'test',
    maximum_score DECIMAL(10,2) NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    date_given DATE NOT NULL,
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (class_subject_id) REFERENCES class_subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE
);

-- 7.6 CA SCORES
CREATE TABLE ca_scores (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    continuous_assessment_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    score_obtained DECIMAL(10,2) NOT NULL,
    percentage DECIMAL(5,2) DEFAULT 0,
    remarks TEXT,
    entered_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ca_student (continuous_assessment_id, student_id),
    FOREIGN KEY (continuous_assessment_id) REFERENCES continuous_assessments(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- 7.7 TERM RESULTS
CREATE TABLE term_results (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    ca_score DECIMAL(10,2) DEFAULT 0,
    ca_weighted_score DECIMAL(10,2) DEFAULT 0,
    exam_score DECIMAL(10,2) DEFAULT 0,
    exam_weighted_score DECIMAL(10,2) DEFAULT 0,
    total_score DECIMAL(10,2) DEFAULT 0,
    percentage DECIMAL(5,2) DEFAULT 0,
    grade VARCHAR(2),
    grade_point DECIMAL(3,2),
    remarks TEXT,
    class_average DECIMAL(5,2),
    position INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,
    UNIQUE KEY unique_term_result (student_id, subject_id, term_id),
    INDEX idx_student_term (student_id, term_id),
    INDEX idx_class_term (class_id, term_id)
);

-- 7.8 TERM SUMMARIES
CREATE TABLE term_summaries (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    total_marks_obtained DECIMAL(10,2) DEFAULT 0,
    total_marks_possible DECIMAL(10,2) DEFAULT 0,
    overall_percentage DECIMAL(5,2) DEFAULT 0,
    average_score DECIMAL(5,2),
    grade VARCHAR(2),
    grade_point_average DECIMAL(3,2),
    class_position INT,
    class_size INT,
    remarks TEXT,
    conduct_grade ENUM('A', 'B', 'C', 'D', 'E', 'F'),
    attendance_percentage DECIMAL(5,2),
    teacher_remarks TEXT,
    head_teacher_remarks TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,
    UNIQUE KEY unique_term_summary (student_id, term_id),
    INDEX idx_term_rank (term_id, overall_percentage DESC)
);

-- 7.9 REPORT CARDS
CREATE TABLE report_cards (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    term_summary_id BIGINT UNSIGNED NOT NULL,
    report_number VARCHAR(100) UNIQUE NOT NULL,
    file_path VARCHAR(255),
    generated_by BIGINT UNSIGNED NOT NULL,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    downloaded_count INT DEFAULT 0,
    last_downloaded_at TIMESTAMP NULL,
    sent_to_parent BOOLEAN DEFAULT FALSE,
    sent_at TIMESTAMP NULL,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (term_summary_id) REFERENCES term_summaries(id) ON DELETE CASCADE
);

-- 7.10 GRADE SCALES
CREATE TABLE grade_scales (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    grade VARCHAR(2) NOT NULL,
    grade_name VARCHAR(50),
    grade_point DECIMAL(3,2) NOT NULL,
    minimum_percentage DECIMAL(5,2) NOT NULL,
    maximum_percentage DECIMAL(5,2) NOT NULL,
    interpretation TEXT,
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    UNIQUE KEY unique_grade_range (school_id, grade)
);

-- =====================================================
-- 8. TIMETABLE MANAGEMENT
-- =====================================================

CREATE TABLE timetables (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    room_number VARCHAR(50),
    is_break BOOLEAN DEFAULT FALSE,
    break_name VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    INDEX idx_class_day (class_id, day_of_week),
    INDEX idx_teacher_time (teacher_id, day_of_week, start_time)
);

-- =====================================================
-- 9. FEE MANAGEMENT TABLES
-- =====================================================

-- 9.1 FEE CATEGORIES
CREATE TABLE fee_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) UNIQUE,
    description TEXT,
    is_optional BOOLEAN DEFAULT FALSE,
    is_recurring BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 9.2 FEE STRUCTURES
CREATE TABLE fee_structures (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    fee_category_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    is_mandatory BOOLEAN DEFAULT TRUE,
    due_date DATE,
    late_fee DECIMAL(12,2) DEFAULT 0,
    discount_percentage DECIMAL(5,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE,
    FOREIGN KEY (fee_category_id) REFERENCES fee_categories(id) ON DELETE CASCADE
);

-- 9.3 FEE PAYMENTS
CREATE TABLE fee_payments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    receipt_number VARCHAR(50) UNIQUE,
    amount DECIMAL(12,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method ENUM('cash', 'bank_transfer', 'card', 'online', 'cheque', 'pos') NOT NULL,
    transaction_id VARCHAR(100),
    bank_name VARCHAR(100),
    cheque_number VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed', 'refunded', 'partial') DEFAULT 'completed',
    payment_proof VARCHAR(255),
    notes TEXT,
    recorded_by BIGINT UNSIGNED NOT NULL,
    approved_by BIGINT UNSIGNED,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    INDEX idx_student_payment (student_id),
    INDEX idx_date (payment_date)
);

-- 9.4 INVOICES
CREATE TABLE invoices (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    term_id BIGINT UNSIGNED NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    paid_amount DECIMAL(12,2) DEFAULT 0,
    outstanding_amount DECIMAL(12,2) DEFAULT 0,
    due_date DATE NOT NULL,
    status ENUM('draft', 'sent', 'partially_paid', 'paid', 'overdue', 'cancelled') DEFAULT 'draft',
    generated_by BIGINT UNSIGNED NOT NULL,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sent_at TIMESTAMP NULL,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE CASCADE
);

-- 9.5 INVOICE ITEMS
CREATE TABLE invoice_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    invoice_id BIGINT UNSIGNED NOT NULL,
    fee_category_id BIGINT UNSIGNED NOT NULL,
    description VARCHAR(255),
    quantity INT DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL,
    total_amount DECIMAL(12,2) DEFAULT 0,
    discount DECIMAL(12,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (fee_category_id) REFERENCES fee_categories(id) ON DELETE CASCADE
);

-- =====================================================
-- 10. LIBRARY MANAGEMENT TABLES
-- =====================================================

-- 10.1 LIBRARY CATEGORIES
CREATE TABLE library_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES library_categories(id) ON DELETE CASCADE
);

-- 10.2 BOOKS
CREATE TABLE books (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    publisher VARCHAR(255),
    publication_year YEAR,
    edition VARCHAR(50),
    category_id BIGINT UNSIGNED,
    total_copies INT DEFAULT 1,
    available_copies INT DEFAULT 1,
    damaged_copies INT DEFAULT 0,
    lost_copies INT DEFAULT 0,
    location VARCHAR(100),
    rack_number VARCHAR(50),
    shelf_number VARCHAR(50),
    price DECIMAL(10,2),
    purchase_date DATE,
    language VARCHAR(50) DEFAULT 'English',
    pages INT,
    summary TEXT,
    cover_image VARCHAR(255),
    status ENUM('available', 'borrowed', 'damaged', 'lost', 'maintenance') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES library_categories(id) ON DELETE SET NULL,
    INDEX idx_isbn (isbn),
    INDEX idx_title (title)
);

-- 10.3 BOOK ISSUES
CREATE TABLE book_issues (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,
    issued_to_type ENUM('student', 'teacher', 'staff') NOT NULL,
    issued_to_id BIGINT UNSIGNED NOT NULL,
    issue_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    status ENUM('issued', 'returned', 'overdue', 'lost', 'damaged') DEFAULT 'issued',
    fine_amount DECIMAL(10,2) DEFAULT 0,
    fine_paid BOOLEAN DEFAULT FALSE,
    issued_by BIGINT UNSIGNED NOT NULL,
    returned_to BIGINT UNSIGNED,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    INDEX idx_due_date (due_date, status),
    INDEX idx_issued_to (issued_to_type, issued_to_id)
);

-- 10.4 LIBRARY SETTINGS
CREATE TABLE library_settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    borrowing_days INT DEFAULT 14,
    max_books_per_student INT DEFAULT 3,
    max_books_per_teacher INT DEFAULT 5,
    fine_per_day DECIMAL(10,2) DEFAULT 50,
    membership_fee DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- =====================================================
-- 11. TRANSPORT MANAGEMENT TABLES
-- =====================================================

-- 11.1 BUS ROUTES
CREATE TABLE bus_routes (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    route_name VARCHAR(100) NOT NULL,
    route_code VARCHAR(50),
    start_point VARCHAR(255),
    end_point VARCHAR(255),
    distance_km DECIMAL(10,2),
    estimated_time INT COMMENT 'Minutes',
    fee_amount DECIMAL(10,2),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 11.2 BUSES
CREATE TABLE buses (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    bus_number VARCHAR(50) UNIQUE NOT NULL,
    registration_number VARCHAR(50),
    model VARCHAR(100),
    capacity INT NOT NULL,
    driver_name VARCHAR(100),
    driver_phone VARCHAR(20),
    driver_license VARCHAR(50),
    route_id BIGINT UNSIGNED,
    gps_tracker_id VARCHAR(100),
    insurance_expiry DATE,
    next_service_date DATE,
    status ENUM('active', 'maintenance', 'inactive', 'on_route') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES bus_routes(id) ON DELETE SET NULL
);

-- 11.3 BUS STOPS
CREATE TABLE bus_stops (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    route_id BIGINT UNSIGNED NOT NULL,
    stop_name VARCHAR(100) NOT NULL,
    stop_order INT NOT NULL,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    estimated_arrival_time TIME,
    pickup_time TIME,
    dropoff_time TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES bus_routes(id) ON DELETE CASCADE
);

-- 11.4 STUDENT TRANSPORT
CREATE TABLE student_transport (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT UNSIGNED NOT NULL,
    bus_id BIGINT UNSIGNED NOT NULL,
    route_id BIGINT UNSIGNED NOT NULL,
    pickup_stop_id BIGINT UNSIGNED NOT NULL,
    dropoff_stop_id BIGINT UNSIGNED NOT NULL,
    academic_year_id BIGINT UNSIGNED NOT NULL,
    fee_amount DECIMAL(10,2),
    status ENUM('active', 'inactive', 'temporary', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES bus_routes(id) ON DELETE CASCADE,
    FOREIGN KEY (pickup_stop_id) REFERENCES bus_stops(id) ON DELETE CASCADE,
    FOREIGN KEY (dropoff_stop_id) REFERENCES bus_stops(id) ON DELETE CASCADE,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE
);

-- =====================================================
-- 12. HOSTEL MANAGEMENT TABLES
-- =====================================================

-- 12.1 HOSTELS
CREATE TABLE hostels (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20),
    type ENUM('boys', 'girls', 'mixed') NOT NULL,
    total_rooms INT DEFAULT 0,
    total_capacity INT DEFAULT 0,
    current_occupancy INT DEFAULT 0,
    warden_name VARCHAR(100),
    warden_phone VARCHAR(20),
    warden_email VARCHAR(100),
    assistant_warden VARCHAR(100),
    address TEXT,
    rules TEXT,
    facilities JSON,
    status ENUM('active', 'inactive', 'full', 'maintenance') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 12.2 HOSTEL ROOMS
CREATE TABLE hostel_rooms (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    hostel_id BIGINT UNSIGNED NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    floor INT,
    capacity INT NOT NULL,
    current_occupancy INT DEFAULT 0,
    room_type ENUM('single', 'double', 'triple', 'quad', 'dormitory') DEFAULT 'double',
    monthly_fee DECIMAL(10,2),
    facilities JSON,
    status ENUM('available', 'occupied', 'maintenance', 'full', 'reserved') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE,
    UNIQUE KEY unique_room (hostel_id, room_number)
);

-- 12.3 HOSTEL ALLOCATIONS
CREATE TABLE hostel_allocations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT UNSIGNED NOT NULL,
    room_id BIGINT UNSIGNED NOT NULL,
    academic_year_id BIGINT UNSIGNED NOT NULL,
    term_id BIGINT UNSIGNED,
    bed_number VARCHAR(10),
    check_in_date DATE,
    expected_check_out_date DATE,
    check_out_date DATE,
    status ENUM('active', 'checked_out', 'vacated', 'transferred', 'expelled') DEFAULT 'active',
    allocation_fee DECIMAL(10,2),
    fee_paid BOOLEAN DEFAULT FALSE,
    remarks TEXT,
    allocated_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES hostel_rooms(id) ON DELETE CASCADE,
    FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE,
    FOREIGN KEY (term_id) REFERENCES terms(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_student (student_id)
);

-- 12.4 HOSTEL ATTENDANCE
CREATE TABLE hostel_attendance (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    hostel_allocation_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    night_out BOOLEAN DEFAULT FALSE,
    night_out_reason TEXT,
    check_in_time TIME,
    check_out_time TIME,
    marked_by BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hostel_allocation_id) REFERENCES hostel_allocations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_daily_attendance (hostel_allocation_id, date)
);

-- =====================================================
-- 13. COMMUNICATION & NOTIFICATION TABLES
-- =====================================================

-- 13.1 ANNOUNCEMENTS
CREATE TABLE announcements (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    type ENUM('general', 'academic', 'event', 'emergency', 'holiday') DEFAULT 'general',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    target_audience ENUM('all', 'students', 'teachers', 'parents', 'staff', 'specific') DEFAULT 'all',
    target_class_id BIGINT UNSIGNED,
    publish_date DATETIME NOT NULL,
    expiry_date DATETIME,
    created_by BIGINT UNSIGNED NOT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    attachments JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (target_class_id) REFERENCES classes(id) ON DELETE SET NULL,
    INDEX idx_publish_date (publish_date)
);

-- 13.2 NOTIFICATIONS
CREATE TABLE notifications (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    link VARCHAR(255),
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_read (user_id, is_read)
);

-- 13.3 MESSAGES
CREATE TABLE messages (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    sender_id BIGINT UNSIGNED NOT NULL,
    receiver_id BIGINT UNSIGNED NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    parent_message_id BIGINT UNSIGNED,
    attachments JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    INDEX idx_conversation (sender_id, receiver_id),
    INDEX idx_receiver_unread (receiver_id, is_read)
);

-- =====================================================
-- 14. EVENT MANAGEMENT TABLES
-- =====================================================

CREATE TABLE events (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_type ENUM('academic', 'sports', 'cultural', 'meeting', 'seminar', 'workshop', 'holiday', 'other') NOT NULL,
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    venue VARCHAR(255),
    venue_map_link VARCHAR(255),
    budget DECIMAL(12,2),
    organizer_name VARCHAR(100),
    organizer_phone VARCHAR(20),
    organizer_email VARCHAR(100),
    color VARCHAR(7) DEFAULT '#0d6efd',
    is_public BOOLEAN DEFAULT TRUE,
    status ENUM('scheduled', 'ongoing', 'completed', 'cancelled', 'postponed') DEFAULT 'scheduled',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    INDEX idx_date (start_datetime)
);

CREATE TABLE event_participants (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT UNSIGNED NOT NULL,
    participant_type ENUM('student', 'teacher', 'staff', 'parent', 'guest') NOT NULL,
    participant_id BIGINT UNSIGNED NOT NULL,
    status ENUM('invited', 'confirmed', 'attended', 'absent', 'cancelled') DEFAULT 'invited',
    attended BOOLEAN DEFAULT FALSE,
    check_in_time TIMESTAMP NULL,
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    UNIQUE KEY unique_participant (event_id, participant_type, participant_id)
);

-- =====================================================
-- 15. INVENTORY & ASSET MANAGEMENT TABLES
-- =====================================================

CREATE TABLE inventory_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id BIGINT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES inventory_categories(id) ON DELETE CASCADE
);

CREATE TABLE inventory_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(100) UNIQUE,
    barcode VARCHAR(100),
    description TEXT,
    quantity INT DEFAULT 0,
    minimum_quantity INT DEFAULT 10,
    maximum_quantity INT DEFAULT 1000,
    unit_price DECIMAL(12,2),
    total_value DECIMAL(12,2) DEFAULT 0,
    unit VARCHAR(20) DEFAULT 'piece',
    location VARCHAR(255),
    supplier VARCHAR(255),
    purchase_date DATE,
    expiry_date DATE,
    warranty_expiry DATE,
    status ENUM('in_stock', 'low_stock', 'out_of_stock', 'discontinued', 'damaged') DEFAULT 'in_stock',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES inventory_categories(id) ON DELETE CASCADE,
    INDEX idx_sku (sku),
    INDEX idx_status (status)
);

CREATE TABLE inventory_transactions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    item_id BIGINT UNSIGNED NOT NULL,
    transaction_type ENUM('purchase', 'issue', 'return', 'adjustment', 'disposal', 'transfer') NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(12,2),
    total_amount DECIMAL(12,2),
    reference_type VARCHAR(50),
    reference_id BIGINT UNSIGNED,
    notes TEXT,
    transaction_date DATE NOT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES inventory_items(id) ON DELETE CASCADE,
    INDEX idx_date (transaction_date)
);

-- =====================================================
-- 16. HUMAN RESOURCE & PAYROLL TABLES
-- =====================================================

-- 16.1 STAFF
CREATE TABLE staff (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED NOT NULL,
    staff_id VARCHAR(50) UNIQUE NOT NULL,
    department VARCHAR(100),
    position VARCHAR(100),
    employment_date DATE NOT NULL,
    contract_end_date DATE,
    contract_type ENUM('permanent', 'contract', 'temporary', 'probation') DEFAULT 'permanent',
    salary DECIMAL(12,2),
    bank_name VARCHAR(100),
    account_number VARCHAR(20),
    account_name VARCHAR(255),
    pension_number VARCHAR(50),
    tax_id VARCHAR(50),
    emergency_contact JSON,
    documents JSON,
    status ENUM('active', 'inactive', 'on_leave', 'suspended', 'terminated', 'retired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- 16.2 PAYROLLS
CREATE TABLE payrolls (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    staff_id BIGINT UNSIGNED NOT NULL,
    month DATE NOT NULL,
    basic_salary DECIMAL(12,2),
    allowances JSON,
    deductions JSON,
    gross_salary DECIMAL(12,2) DEFAULT 0,
    net_salary DECIMAL(12,2),
    payment_date DATE,
    payment_status ENUM('pending', 'paid', 'failed', 'processing') DEFAULT 'pending',
    transaction_id VARCHAR(100),
    payslip_path VARCHAR(255),
    processed_by BIGINT UNSIGNED,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
    INDEX idx_month (month)
);

-- =====================================================
-- 17. ONLINE LEARNING TABLES
-- =====================================================

CREATE TABLE online_courses (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    video_url VARCHAR(255),
    materials JSON,
    duration_hours INT,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);

CREATE TABLE course_enrollments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    course_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    enrollment_date DATE NOT NULL,
    progress_percentage INT DEFAULT 0,
    completed_at TIMESTAMP NULL,
    certificate_issued BOOLEAN DEFAULT FALSE,
    certificate_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES online_courses(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (course_id, student_id)
);

-- =====================================================
-- 18. MULTI-SCHOOL MANAGEMENT TABLES
-- =====================================================

CREATE TABLE school_branches (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    parent_school_id BIGINT UNSIGNED NOT NULL,
    branch_name VARCHAR(255) NOT NULL,
    branch_code VARCHAR(50),
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    principal_name VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_school_id) REFERENCES schools(id) ON DELETE CASCADE
);

CREATE TABLE student_transfers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    student_id BIGINT UNSIGNED NOT NULL,
    from_school_id BIGINT UNSIGNED NOT NULL,
    to_school_id BIGINT UNSIGNED NOT NULL,
    from_class_id BIGINT UNSIGNED,
    to_class_id BIGINT UNSIGNED,
    transfer_date DATE NOT NULL,
    reason TEXT,
    documents JSON,
    status ENUM('pending', 'approved', 'completed', 'rejected') DEFAULT 'pending',
    approved_by BIGINT UNSIGNED,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (from_school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (to_school_id) REFERENCES schools(id) ON DELETE CASCADE
);

-- =====================================================
-- 19. BACKUP & SYSTEM TABLES
-- =====================================================

CREATE TABLE backups (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED,
    backup_type ENUM('database', 'files', 'full') NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size BIGINT,
    backup_location VARCHAR(255),
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    restored_at TIMESTAMP NULL,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE SET NULL
);

-- =====================================================
-- 20. SETTINGS & CONFIGURATION TABLES
-- =====================================================

CREATE TABLE school_settings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    setting_key VARCHAR(100) NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json', 'file') DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    UNIQUE KEY unique_setting (school_id, setting_key)
);

-- =====================================================
-- INDEXES FOR OPTIMAL PERFORMANCE
-- =====================================================

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_school ON users(school_id);
CREATE INDEX idx_students_admission ON students(admission_number);
CREATE INDEX idx_students_class ON students(current_class_id);
CREATE INDEX idx_students_status ON students(status);
CREATE INDEX idx_student_attendance_date ON student_attendance(date);
CREATE INDEX idx_student_attendance_student ON student_attendance(student_id, date);
CREATE INDEX idx_fee_payments_student ON fee_payments(student_id);
CREATE INDEX idx_fee_payments_date ON fee_payments(payment_date);
CREATE INDEX idx_exam_results_student ON exam_results(student_id);
CREATE INDEX idx_exam_results_exam ON exam_results(exam_id);
CREATE INDEX idx_term_results_student_term ON term_results(student_id, term_id);
CREATE INDEX idx_term_results_class_term ON term_results(class_id, term_id);
CREATE INDEX idx_term_summaries_term_rank ON term_summaries(term_id, overall_percentage DESC);
CREATE INDEX idx_book_issues_due ON book_issues(due_date, status);
CREATE INDEX idx_books_title ON books(title);
CREATE INDEX idx_books_isbn ON books(isbn);
CREATE INDEX idx_timetables_class_day ON timetables(class_id, day_of_week);
CREATE INDEX idx_hostel_allocations_status ON hostel_allocations(status);
CREATE INDEX idx_events_date ON events(start_datetime);
CREATE INDEX idx_notifications_user_read ON notifications(user_id, is_read);
CREATE INDEX idx_messages_receiver_unread ON messages(receiver_id, is_read);

-- =====================================================
-- INSERT DEFAULT DATA
-- =====================================================

INSERT IGNORE INTO schools (id, name, code, address, phone, email, status, created_at) VALUES 
(1, 'Demo Central School', 'DEMO001', '123 Education Road, Lagos, Nigeria', '+2348012345678', 'info@democentralschool.com', 'active', NOW());

INSERT IGNORE INTO users (id, school_id, username, email, password, status, email_verified_at, created_at) VALUES 
(1, 1, 'admin', 'admin@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active', NOW(), NOW());

-- Verify all tables created
SELECT COUNT(*) as total_tables FROM information_schema.tables WHERE table_schema = DATABASE();