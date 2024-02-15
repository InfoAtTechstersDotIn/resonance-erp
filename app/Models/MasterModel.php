<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{
    // BATCH
    public function addbatch($name)
    {
        $data['batchname'] = $name;

        $db = db_connect();
        $builder = $db->table('batchlookup');
        $builder->insert($data);

        $db->close();
    }

    public function update_batch($id, $name)
    {
        $data['batchname'] = $name;

        $db = db_connect();
        $builder = $db->table('batchlookup');
        $builder->where('batchid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deletebatch($id)
    {
        $db = db_connect();
        $builder = $db->table('batchlookup');
        $builder->where('batchid', $id);
        $builder->delete();

        $db->close();
    }
    // BATCH

    // BRANCH
    public function addbranch($name, $latitude, $longitude, $branch_address)
    {
        $data['branchname'] = $name;
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;
        $data['branch_address'] = $branch_address;

        $db = db_connect();
        $builder = $db->table('branchlookup');
        $builder->insert($data);

        $db->close();
    }
    public function addmaterialrequisition($name)
    {
         $data['materialrequisitionname'] = $name;
        $db = db_connect();
        $builder = $db->table('materialrequisitionlookup');
        $builder->insert($data);

        $db->close();
    }

    public function updatebranch($id, $name, $latitude, $longitude, $branch_address)
    {
        $data['branchname'] = $name;
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;
        $data['branch_address'] = $branch_address;

        $db = db_connect();
        $builder = $db->table('branchlookup');
        $builder->where('branchid', $id);
        $builder->update($data);
        $db->close();
    }
    public function updatematerialrequisition($id, $name)
    {
        $data['materialrequisitionname'] = $name;
        $db = db_connect();
        $builder = $db->table('materialrequisitionlookup');
        $builder->where('materialrequisitionid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deletebranch($id)
    {
        $db = db_connect();
        $builder = $db->table('branchlookup');
        $builder->where('branchid', $id);
        $builder->delete();

        $db->close();
    }
    public function deletematerialrequisition()
    {
        
        $db = db_connect();
        $builder = $db->table('materialrequisitionlookup');
        $builder->where('materialrequisitionid', $id);
        $builder->delete();

        $db->close();
    }
    // BRANCH

    // COURSE
    public function addcourse($name)
    {
        $data['coursename'] = $name;

        $db = db_connect();
        $builder = $db->table('courselookup');
        $builder->insert($data);

        $db->close();
    }

    public function updatecourse($id, $name)
    {
        $data['coursename'] = $name;

        $db = db_connect();
        $builder = $db->table('courselookup');
        $builder->where('courseid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deletecourse($id)
    {
        $db = db_connect();
        $builder = $db->table('courselookup');
        $builder->where('courseid', $id);
        $builder->delete();

        $db->close();
    }
    // COURSE

    // SECTION
    public function addsection($name)
    {
        $data['sectionname'] = $name;

        $db = db_connect();
        $builder = $db->table('sectionlookup');
        $builder->insert($data);

        $db->close();
    }

    public function updatesection($id, $name)
    {
        $data['sectionname'] = $name;

        $db = db_connect();
        $builder = $db->table('sectionlookup');
        $builder->where('sectionid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deletesection($id)
    {
        $db = db_connect();
        $builder = $db->table('sectionlookup');
        $builder->where('sectionid', $id);
        $builder->delete();

        $db->close();
    }
    // SECTION


    // SUBJECT
    public function addsubject($name)
    {
        $data['subjectname'] = $name;

        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->insert($data);

        $db->close();
    }

    public function updatesubject($id, $name)
    {
        $data['subjectname'] = $name;

        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->where('subjectid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deletesubject($id)
    {
        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->where('subjectid', $id);
        $builder->delete();

        $db->close();
    }
    // SUBJECT

    // CLASS
    public function addclass($name)
    {
        $data['subjectname'] = $name;

        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->insert($data);

        $db->close();
    }

    public function updateclass($id, $name)
    {
        $data['subjectname'] = $name;

        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->where('subjectid', $id);
        $builder->update($data);
        $db->close();
    }

    public function deleteclass($id)
    {
        $db = db_connect();
        $builder = $db->table('subjectlookup');
        $builder->where('subjectid', $id);
        $builder->delete();

        $db->close();
    }
    // CLASS

}
