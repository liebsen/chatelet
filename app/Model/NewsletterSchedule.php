<?php

class NewsletterSchedule extends AppModel {
  public function beforeSave($options = array()) {
    // Transform birthday to datetime format

   	if (isset($this->data[$this->alias]['schedule_date'])) {
    	$date = explode('/', $this->data[$this->alias]['schedule_date']);
    	$date = implode('-', array($date[2], $date[1], $date[0]));
    	$this->data[$this->alias]['schedule_date'] = $date;
    }

    return true;
  }
}
