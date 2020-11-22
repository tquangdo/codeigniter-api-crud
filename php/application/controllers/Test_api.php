<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {
    function index()
    {
        $this->load->view('api_view');
    }

    function action()
    {
        if($this->input->post('data_action_fromv'))
        {
            $data_action_fromv = $this->input->post('data_action_fromv');
        //    if($data_action_fromv == "Delete")
        //    {
        //     $api_url = "http://localhost/index.php/api/delete";

        //     $form_data = array(
        //      'id'  => $this->input->post('user_id')
        //     );

        //     $client = curl_init($api_url);

        //     curl_setopt($client, CURLOPT_POST, true);

        //     curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

        //     curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        //     $response = curl_exec($client);

        //     curl_close($client);

        //     echo $response;
        //    }

        //    if($data_action_fromv == "Edit")
        //    {
        //     $api_url = "http://localhost/index.php/api/update";

        //     $form_data = array(
        //      'first_name'  => $this->input->post('first_name'),
        //      'last_name'   => $this->input->post('last_name'),
        //      'id'    => $this->input->post('user_id')
        //     );

        //     $client = curl_init($api_url);

        //     curl_setopt($client, CURLOPT_POST, true);

        //     curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

        //     curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        //     $response = curl_exec($client);

        //     curl_close($client);

        //     echo $response;
        //    }

        //    if($data_action_fromv == "fetch_single")
        //    {
        //     $api_url = "http://localhost/index.php/api/fetch_single";

        //     $form_data = array(
        //      'id'  => $this->input->post('user_id')
        //     );

        //     $client = curl_init($api_url);

        //     curl_setopt($client, CURLOPT_POST, true);

        //     curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

        //     curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        //     $response = curl_exec($client);

        //     curl_close($client);

        //     echo $response;
        //    }

        //    if($data_action_fromv == "Insert")
        //    {
        //     $api_url = "http://localhost/index.php/api/insert";
        //     $form_data = array(
        //      'first_name'  => $this->input->post('first_name'),
        //      'last_name'   => $this->input->post('last_name')
        //     );

        //     $client = curl_init($api_url);

        //     curl_setopt($client, CURLOPT_POST, true);

        //     curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

        //     curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

        //     $response = curl_exec($client);

        //     curl_close($client);

        //     echo $response;
        //    }

            if($data_action_fromv == "fetch_all_fromv")
            {
                $ch = curl_init();
                if ($ch !== false)
                {
                    $target_url = "http://192.168.0.15:8000/index.php/api"; //KO được localhost hay 127.0.0.1
                    curl_setopt($ch, CURLOPT_URL,$target_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                    $response = curl_exec($ch);
                    if ($response === false)
                    {  
                        print_r('Curl error: ' . curl_error($ch));
                        die;
                    }
                    // echo "<script> console.log('response: ',",$response,");</script>"; //bị bể format bootstrap
                    curl_close($ch);
                    $result = json_decode($response); //JSON string -> PHP array
                }
                else
                {
                    echo "<script> console.log('LỖI!!!!!');</script>";
                }
                $output = '';
                if(count($result) > 0)
                {
                    foreach($result as $row_item)
                    {
                        // $row_item-> map với table's column name
                        $output .= '
                            <tr>
                                <td>'.$row_item->first_name.'</td>
                                <td>'.$row_item->last_name.'</td>
                                <td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row_item->id.'">Edit</button></td>
                                <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row_item->id.'">Delete</button></td>
                            </tr>
                        ';
                    }
                }
                else
                {
                    $output .= '
                        <tr>
                            <td colspan="4" align="center">No Data Found</td>
                        </tr>
                    ';
                }
                echo $output; //trả HTML data về cho Ajax req của api_view.php
            }
        }
    }
}

?>