<form method="POST" action="{{ route('adminnew.submitAllData') }}">
    @csrf
<div style="width: 100%;">
    <div style="width: 50%;float:left">
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Functions Table</th>
            </tr>
            <tr>
                <th>Id</th>
                <th>Function Name</th>
                <th>Program Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $function->id }} <input type="hidden" name="functions_id" value="{{ $function->id }}"></td>
                <td>{{ $function->function_name }}</td>
                <td>{{ $function->prgm_name }} <input type="hidden" name="prgm_name" value="{{ $function->prgm_name }}"></td>
                <td>p_functions</td>
            </tr>
            </tbody>
        </table>
        <br>
        @php
            $factor = $function->factors()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="5">Factors Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Factor id</th>
                <th>Factor Name</th>
                <th>Factor uom</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($factor->count() > 0)
                @foreach($factor as $fac)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $fac->id }} <input type="hidden" name="factor_id" value="{{ $fac->id }}"></td>
                        <td>{{ $fac->factor_name }}</td>
                        <td>{{ $fac->pivot->factor_uom }} <input type="hidden" name="factor_uom" value="{{ $fac->pivot->factor_uom }}"></td>
                        <td>p_functions_factor</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $modifier = $function->modifiers()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="5">Modifiers Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Modifier id</th>
                <th>Modifier name</th>
                <th>Modifier uom</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($modifier->count() > 0)
                @foreach($modifier as $mod)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $mod->id }} <input type="hidden" name="modifier_id" value="{{ $mod->id }}"></td>
                        <td>{{ $mod->modifier_name }}</td>
                        <td>{{ $mod->pivot->modifier_uom }} <input type="hidden" name="modifier_uom" value="{{ $mod->pivot->modifier_uom }}"></td>
                        <td>p_functions_modifier</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $inputs = $function->inputVariables()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Measurement / Input variables Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Input id</th>
                <th>Input Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($inputs->count() > 0)
                @foreach($inputs as $inp)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $inp->id }}</td>
                        <td>{{ $inp->variable_name }}</td>
                        <td>p_functions_measurement_variables</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $outputs = $function->outputVariables()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Output variables Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Output id</th>
                <th>Output Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($outputs->count() > 0)
                @foreach($outputs as $out)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $out->id }}</td>
                        <td>{{ $out->variable_name }}</td>
                        <td>p_output_variables</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $inpAsoutputs = $function->inputAsOutputVariables()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Output as Input variables Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Output id</th>
                <th>Output Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($inpAsoutputs->count() > 0)
                @foreach($inpAsoutputs as $out1)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $out1->id }}</td>
                        <td>{{ $out1->variable_name }}</td>
                        <td>p_functions_output_input_varibles</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $designVarients = $function->designVarients()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Design Varients Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Design id</th>
                <th>Design Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($designVarients->count() > 0)
                @foreach($designVarients as $design)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $design->id }}</td>
                        <td>{{ $design->design_type_name }}</td>
                        <td>p_design_type_functions</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $conditionalStatements = $function->conditionalStatements()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Conditional Statements Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Condition id</th>
                <th>Condition Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($conditionalStatements->count() > 0)
                @foreach($conditionalStatements as $cs)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $cs->id }}</td>
                        <td>{{ $cs->description }}</td>
                        <td>p_functions_conditional_statements</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $childs = $function->child()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">Hierarchy Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Child id</th>
                <th>Child Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($childs->count() > 0)
                @foreach($childs as $ch)
                    @php
                        $childsParent = App\Models\Patterns\Functions::where('id',$ch->id)->first();
                    @endphp
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $ch->id }}</td>
                        <td>{{ $childsParent->function_name }}</td>
                        <td>p_functions_hierarchy</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <br>
        @php
            $ifConditions = $function->ifConditions()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="4">If conditions Table</th>
            </tr>
            <tr>
                <th>Functions Id</th>
                <th>Ifcondition id</th>
                <th>Ifcondition Name</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($ifConditions->count() > 0)
                @foreach($ifConditions as $ifc)
                    <tr>
                        <td>{{ $function->id }}</td>
                        <td>{{ $ifc->id }}</td>
                        <td>{{ $ifc->condition_variable }}</td>
                        <td>p_functions_if_conditions</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        <br>
        @php
            $ifConditions = $function->ifConditions()->get();
        @endphp
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th colspan="5">Conditional variablesTable</th>
            </tr>
            <tr>
                <th>Ifcondition Id</th>
                <th>Conditional variable id</th>
                <th>Conditional variable Name</th>
                <th>Conditional variable Type</th>
                <th>Table Name</th>
            </tr>
            </thead>
            <tbody>
            @if($ifConditions->count() > 0)
                @foreach($ifConditions as $ifc)
                    @php
                        $condvars = $ifc->conditionalVariables()->get();
                    @endphp
                    @if($condvars->count() > 0)
                        @foreach($condvars as $cv)
                            <tr>
                                <td>{{ $ifc->id }}</td>
                                <td>{{ $cv->id }}</td>
                                <td>{{ $cv->condition_text }}</td>
                                <td>{{ $cv->condition_type }}</td>
                                <td>p_conditional_variables</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>

    </div>
    <div style="width: 50%;float: left;">
        <table border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>New Function name</th>
                <th>Conditional Statement</th>
                <th>Condition id</th>
            </tr>
        </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="function_name" value=""> </td>
                    <td><input type="text" name="description" value=""></td>
                    <td><input type="text" name="condition_id" value="0"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Save"></td>
                </tr>
            </tbody>
        </table>
		
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
    </div>
</div>
</form>
