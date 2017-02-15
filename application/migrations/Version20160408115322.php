<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Rougin\SparkPlug\Instance;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160408115322 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $ci = Instance::create(ROOT_PATH);
        $ci->load->library('encrypt');

        $conn = $this->connection;
        $conn->insert('users', [
            'first_name' => 'M. Sulton',
            'last_name' => 'Hasanuddin',
            'email' => 'msulhas@gmail.com',
            'password' => $ci->encrypt->encode('User1234'),
            'type' => \UserStatic::TYPE_CUSTOMER,
            'is_teacher' => 1,
            'status' => \UserStatic::STATUS_ACTIVE
        ]);

        $user_id = $conn->lastInsertId();
        $conn->insert('user_details', [
            'birth_date' => '1986-12-15',
            'home_phone' => '021-1234567',
            'mobile_phone' => '082232856363',
            'gender' => \UserDetailStatic::GENDER_MALE,
            'marital_status' => \UserDetailStatic::MARITAL_SINGLE,
            'academic_level' => 4,
            'user_id' => $user_id
        ]);

        $conn->insert('teacher_details', [
            'user_id' => $user_id,
            'goal' => 'Mensejahterakan keluarga',
            'objective' => \TeacherDetailStatic::OBJECTIVE_GROW_BUSINESS,
            'bio' => '<p>Lorem ipsum dolor sit amet, dicta oportere ad est, ea eos partem neglegentur theophrastus. Esse voluptatum duo ne, expetenda corrumpit no per, at mei nobis lucilius. No eos semper aperiri neglegentur, vis noluisse quaestio no. Vix an nostro inimicus, qui ut animal fabellas reprehendunt. In quando repudiare intellegebat sed, nam suas dicta melius ea.</p>

<p>Mei ut decore accusam consequat, alii dignissim no usu. Phaedrum intellegat sit ut, no pri mutat eirmod. In eum iriure perpetua adolescens, pri dicunt prodesset et. Vis dicta postulant ad.</p>',
            'teacher_type' => \TeacherDetailStatic::TYPE_INDIVIDUAL,
            'job' => 'PHP Programmer',
            'bank_branch_name' => 'KCP Harmoni Pusat',
            'bank_account_number' => '1234567890',
            'monthly_class_envisaged' => \TeacherDetailStatic::CLASSES_4_TO_6,
            'bank_id' => 37
        ]);

        $user_id = 1;
        $conn->insert('user_details', [
            'birth_date' => '1986-12-15',
            'home_phone' => '021-1234567',
            'mobile_phone' => '082232856363',
            'gender' => \UserDetailStatic::GENDER_MALE,
            'marital_status' => \UserDetailStatic::MARITAL_SINGLE,
            'academic_level' => 4,
            'user_id' => $user_id
        ]);

        $conn->insert('teacher_details', [
            'user_id' => $user_id,
            'goal' => 'Mensejahterakan keluarga',
            'objective' => \TeacherDetailStatic::OBJECTIVE_GROW_BUSINESS,
            'bio' => '<p>Lorem ipsum dolor sit amet, dicta oportere ad est, ea eos partem neglegentur theophrastus. Esse voluptatum duo ne, expetenda corrumpit no per, at mei nobis lucilius. No eos semper aperiri neglegentur, vis noluisse quaestio no. Vix an nostro inimicus, qui ut animal fabellas reprehendunt. In quando repudiare intellegebat sed, nam suas dicta melius ea.</p>

<p>Mei ut decore accusam consequat, alii dignissim no usu. Phaedrum intellegat sit ut, no pri mutat eirmod. In eum iriure perpetua adolescens, pri dicunt prodesset et. Vis dicta postulant ad.</p>',
            'teacher_type' => \TeacherDetailStatic::TYPE_INDIVIDUAL,
            'job' => 'PHP Programmer',
            'bank_branch_name' => 'KCP Harmoni Pusat',
            'bank_account_number' => '1234567890',
            'monthly_class_envisaged' => \TeacherDetailStatic::CLASSES_4_TO_6,
            'bank_id' => 37
        ]);

        $conn->insert('users', [
            'first_name' => 'Fathan',
            'last_name' => 'Fathan',
            'email' => 'karir.fathan@gmail.com',
            'password' => $ci->encrypt->encode('fathan123'),
            'type' => \UserStatic::TYPE_CUSTOMER,
            'is_student' => 1,
            'status' => \UserStatic::STATUS_ACTIVE
        ]);

        $user_id = $conn->lastInsertId();
        $conn->insert('user_details', [
            'birth_date' => '1986-12-15',
            'home_phone' => '021-1234567',
            'mobile_phone' => '082232856363',
            'gender' => \UserDetailStatic::GENDER_MALE,
            'marital_status' => \UserDetailStatic::MARITAL_SINGLE,
            'academic_level' => 4,
            'user_id' => $user_id
        ]);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
