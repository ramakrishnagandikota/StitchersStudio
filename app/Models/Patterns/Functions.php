<?php

namespace App\Models\Patterns;

use App\Models\Patterns\DesignType;
use App\Models\Patterns\MeasurementVariables;
use App\Models\Patterns\OutputVariables;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\ConditionalStatement;
use App\Models\Patterns\Factor;
use App\Models\Patterns\Instructions;
use App\Models\Patterns\Modifier;
use App\Models\Patterns\PatternTemplate;
use App\Models\Patterns\Section;
use App\Models\Patterns\Snippet;
use App\Models\Patterns\FunctionsHierarchy;
use App\Models\Patterns\ConditionalVariable;
use App\Models\Patterns\IfConditions;

class Functions extends Model
{
    protected $table = 'p_functions';



    public function inputVariables(){
        return $this->belongsToMany(MeasurementVariables::class,'p_functions_measurement_variables','functions_id','measurement_variables_id');
    }

    public function outputVariables(){
        return $this->belongsToMany(OutputVariables::class,'p_functions_output_varibles','functions_id','output_variables_id');
    }

    public function inputAsOutputVariables(){
        return $this->belongsToMany(OutputVariables::class,'p_functions_output_input_varibles','functions_id','output_variables_id');
    }

    public function designVarients(){
        return $this->belongsToMany(DesignType::class,'p_design_type_functions','functions_id','design_type_id');
    }

    public function conditionalStatements(){
        return $this->belongsToMany(ConditionalStatement::class,'p_functions_conditional_statements','functions_id','conditional_statements_id');
    }

    public function parent(){
        return $this->hasMany(FunctionsHierarchy::class,'parent_functions_id');
    }

    public function child(){
        return $this->hasMany(FunctionsHierarchy::class,'child_functions_id');
    }

    public function hasManyChildren($childs){
        if(is_array($childs)){
            return true;
        }else{
            return false;
        }
    }

    public function hasChildren($child){

    }

    public function factors(){
        return $this->belongsToMany(Factor::class,'p_functions_factor','functions_id','factor_id')->withPivot(['factor_uom']);
    }

    public function modifiers(){
        return $this->belongsToMany(Modifier::class,'p_functions_modifier','functions_id','modifier_id')->withPivot(['modifier_uom']);
    }

    public function ifConditions(){
        return $this->belongsToMany(IfConditions::class,'p_functions_if_conditions','functions_id','if_conditions_id');
    }

    public function conditionalVariables(){
        return $this->hasMany(ConditionalVariable::class,'functions_id');
    }
}
