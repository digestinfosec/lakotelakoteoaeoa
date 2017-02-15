<?php

class Schedule_model extends MY_Model
{
    // Get all schedules for a class
    public function get_schedules($class_id)
    {
        $this->load->model('address_model');
        $this->address_model->db->select('schedules.*, schedules.id as schedule_id, addresses.*')
            ->join('schedules', 'addresses.id = schedules.address_id', 'left')
            ->order_by('schedules.date', 'ASC')
            ->where('class_id', $class_id);
        $query = $this->db->get('addresses');
        return $query->result();
    }

    // Get a schedule by ID
    public function get_schedule_by_id($schedule_id)
    {
        $this->db->select('schedules.*, addresses.*');
        $this->db->join('addresses', 'addresses.id = schedules.address_id', 'left');
        $this->db->order_by('date', 'asc');
        $this->db->where('schedules.id', $schedule_id);
        $query = $this->db->get('schedules');
        return $query->row();
    }

    // Get all schedules within a date
    public function get_schedules_from_date($date)
    {
        $this->db->select('schedules.*');
        $this->db->where('schedules.date', $date);
        $this->db->order_by('schedules.date', 'ASC');
        $query = $this->db->get('schedules');
        return $query->result();
    }

    // Get the starting date and time for a class
    public function get_first_time($class_id)
    {
        $this->db->select('CONCAT(`date`, " ", `start_time`) as start_date', TRUE);
        $this->db->where('class_id', $class_id);
        $this->db->order_by('start_time', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('schedules');

        return $query->row()->start_date;
    }

    // Get the last date and time (schedule) for a class
    public function get_last_time($class_id)
    {
        $this->db->select('CONCAT(`date`, " ", `end_time`) as end_date', TRUE);
        $this->db->where('class_id', $class_id);
        $this->db->order_by('end_date', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('schedules');

        return $query->row()->end_date;
    }

    // Save the schedules for a class  from input
    public function save_class_schedules($class_id)
    {
        $schedule_ids = $this->input->post('schedule_ids[]');
        $schedule_date = $this->input->post('schedule_date[]');
        $schedule_start = $this->input->post('schedule_start[]');
        $schedule_end = $this->input->post('schedule_end[]');
        $schedule_venue = $this->input->post('schedule_venue[]');
        $schedule_address_1 = $this->input->post('schedule_address_1[]');
        $schedule_address_2 = $this->input->post('schedule_address_2[]');
        $schedule_unit_number = $this->input->post('schedule_unit_number[]');
        $schedule_postal_code = $this->input->post('schedule_postal_code[]');
        $schedule_city = $this->input->post('schedule_city[]');
        $schedule_state = $this->input->post('schedule_state[]');
        $schedule_country = $this->input->post('schedule_country[]');
        $schedule_lat = $this->input->post('schedule_lat[]');
        $schedule_long = $this->input->post('schedule_long[]');

        $course = $this->course_model->get_course($class_id);

        $schedules = $this->get_schedules($class_id);

        foreach($schedule_date as $key => $value) {

            // Check first if it's a blank array or not
            if ($schedule_date[$key] == "") continue;

            $this->load->model('address_model');
            $data_address = array(
                'address_line1' => $schedule_address_1[$key],
                'address_line2' => $schedule_address_2[$key],
                'unit_number' => $schedule_unit_number[$key],
                'postal_code' => $schedule_postal_code[$key],
                'city' => $schedule_city[$key],
                'state' => $schedule_state[$key],
                'country' => $schedule_country[$key],
                'name' => $schedule_venue[$key],
                'latitude' => $schedule_lat[$key],
                'longitude' => $schedule_long[$key]);

            // Update existing schedule and address
            if($schedule_ids[$key] != "") {

                $this->db->where('id', $schedule_ids[$key]);
                $schedule = $this->db->get('schedules')->row();
                $address_id = $schedule->address_id;

                $address = $this->address_model->update_address($address_id, $data_address);
                $data_schedule = array(
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $course->available_seat,
                        'date' => $schedule_date[$key],
                        'start_time' => date("H:i", strtotime($schedule_start[$key])),
                        'end_time' => date("H:i", strtotime($schedule_end[$key])));

                $this->db->where('id', $schedule_ids[$key]);
                $this->db->update('schedules', $data_schedule);
            }
            // Create a new schedule and address
            else {
                $address_id = $this->address_model->create_address($data_address);

                $data_schedule = array(
                        'address_id' => $address_id,
                        'class_id' => $class_id,
                        'available_seat_left' => $course->available_seat,
                        'date' => $schedule_date[$key],
                        'start_time' => date("H:i", strtotime($schedule_start[$key])),
                        'end_time' => date("H:i", strtotime($schedule_end[$key])));

                $this->db->insert('schedules', $data_schedule);
            }
        }

        // If any of the schedule is deleted
        $cnt_saved = count($schedules);
        $cnt_new = count($schedule_date);
        if ($cnt_new < $cnt_saved) {
            for($i = $cnt_new; $i < $cnt_saved; $i++) {
                $this->db->where('id', $schedules[$i]->schedule_id);
                $this->db->delete('schedules');
            }
        }
    }

    // Change the class schedule from input
    public function change_schedule()
    {
        $schedule_ids = $this->input->post('schedule_ids[]');
        $schedule_date = $this->input->post('schedule_date[]');
        $schedule_start = $this->input->post('schedule_start[]');
        $schedule_end = $this->input->post('schedule_end[]');

        foreach($schedule_date as $key => $value) {

            if ($schedule_ids[$key] != "") {
                $data_schedule = array(
                    'date' => $schedule_date[$key],
                    'start_time' => date("H:i", strtotime($schedule_start[$key])),
                    'end_time' => date("H:i", strtotime($schedule_end[$key]))
                );

                $this->db->where('id', $schedule_ids[$key]);
                $this->db->update('schedules', $data_schedule);
            }
        }

    }

    // Change the classs venue from input
    public function change_venue()
    {
        $address_ids = $this->input->post('address_ids[]');
        $schedule_address_1 = $this->input->post('schedule_address_1[]');
        $schedule_address_2 = $this->input->post('schedule_address_2[]');
        $schedule_unit_number = $this->input->post('schedule_unit_number[]');
        $schedule_postal_code = $this->input->post('schedule_postal_code[]');
        $schedule_city = $this->input->post('schedule_city[]');
        $schedule_state = $this->input->post('schedule_state[]');
        $schedule_country = $this->input->post('schedule_country[]');
        $latitude = $this->input->post('schedule_lat[]');
        $longitude = $this->input->post('schedule_long[]');
        foreach($address_ids as $key => $value) {

            $data_address = array(
                'address_line1' => $schedule_address_1[$key],
                'address_line2' => $schedule_address_2[$key],
                'unit_number' => $schedule_unit_number[$key],
                'postal_code' => $schedule_postal_code[$key],
                'city' => $schedule_city[$key],
                'state' => $schedule_state[$key],
                'country' => $schedule_country[$key],
                'latitude' => $latitude[$key],
                'longitude' => $longitude[$key]);

            $this->load->model('address_model');

            if ($address_ids[$key] != "") {
                $this->address_model->update_address($value, $data_address);
            }
        }

    }

    // Revoke the seat for a schedule
    public function revoke_seat($schedule_id, $available_seat)
    {
        $this->db->where('id', $schedule_id);
        $this->db->update('schedules', [
            'available_seat_left' => $available_seat+1
        ]);
    }
}
