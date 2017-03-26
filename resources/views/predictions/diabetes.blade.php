@extends('layouts.app')

@section('title')
    Diabetes Prediction
@endsection

@section('content')

    @component('layouts.card', [
        'cardTitle' => 'Diabetes Prediction',
        'colSize' => 12
    ])
    <form role="form" method="POST" action="/predict/diabetes">
        {{ csrf_field() }}

        @if(isset($results))
            <div class="alert alert-{{ $results['Ensemble'] != 1 ? 'success' : 'warning' }}" role="alert">
                @if($results['Ensemble'] == 1)
                    You might have risk of developing diabetes.
                @else
                    You do not have risk of diabetes.
                @endif
                <button class="btn btn-primary float-right" data-toggle="collapse" data-target="#prediction-results-detail-view" aria-expanded="false" aria-controls="prediction-results-detail-view">
                    Show Details
                </button>
                <span class="clearfix"></span>
            </div>
            <div class="collapse" id="prediction-results-detail-view">
                <div class="card card-block justify-content-center">
                    <p>We calculated risks using various algorithms.</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Algorithm</th>
                                    <th>Risk of Diabetes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr{!! $results['LogisticRegression'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Logistic Regression</td>
                                    <td>{{ $results['LogisticRegression'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['LinearSVC'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Linear Support Vector Classifier</td>
                                    <td>{{ $results['LinearSVC'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['NaiveBayes'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Naive Bayes</td>
                                    <td>{{ $results['NaiveBayes'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['KNeighbors'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>K-Nearest Neighbors</td>
                                    <td>{{ $results['KNeighbors'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['NeuralNetwork'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Neural Network (Multi-Layer Perceptron)</td>
                                    <td>{{ $results['NeuralNetwork'] ? 'Yes' : 'No' }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr{!! $results['Ensemble'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <th>Ensemble Classifier (Combination of all above)</th>
                                    <th>{{ $results['Ensemble'] ? 'Yes' : 'No' }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group mt-2 row{{ $errors->has('age') ? ' has-danger' : '' }}">
            <label for="age" class="col-4 col-form-label text-right">Age</label>

            <div class="col-6">
                <input id="age" type="number" class="form-control" name="age" value="{{ old('age') }}" required>

                @if ($errors->has('age'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('age') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('pregnant') ? ' has-danger' : '' }}">
            <label for="pregnant" class="col-4 col-form-label text-right">No of times Pregnant</label>

            <div class="col-6">
                <input id="pregnant" type="number" class="form-control" name="pregnant" value="{{ old('pregnant') }}" required>

                @if ($errors->has('pregnant'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('pregnant') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('plasma_glucose_concentration') ? ' has-danger' : '' }}">
            <label for="plasma_glucose_concentration" class="col-4 col-form-label text-right">Plasma Glucose Concentration</label>

            <div class="col-6">
                <input id="plasma_glucose_concentration" type="number" class="form-control" name="plasma_glucose_concentration" value="{{ old('plasma_glucose_concentration') }}" required>

                @if ($errors->has('plasma_glucose_concentration'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('plasma_glucose_concentration') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('diastolic_bp') ? ' has-danger' : '' }}">
            <label for="diastolic_bp" class="col-4 col-form-label text-right">Diastolic BP</label>

            <div class="col-6">
                <input id="diastolic_bp" type="number" class="form-control" name="diastolic_bp" value="{{ old('diastolic_bp') }}" required>

                @if ($errors->has('diastolic_bp'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('diastolic_bp') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('tsft') ? ' has-danger' : '' }}">
            <label for="tsft" class="col-4 col-form-label text-right">Triceps Skin Fold Thickness</label>

            <div class="col-6">
                <input id="tsft" type="number" class="form-control" name="tsft" value="{{ old('tsft') }}" required>

                @if ($errors->has('tsft'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('tsft') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('serum_insulin') ? ' has-danger' : '' }}">
            <label for="serum_insulin" class="col-4 col-form-label text-right">2-hr Serum Insulin (μU/ml)</label>

            <div class="col-6">
                <input id="serum_insulin" type="number" class="form-control" name="serum_insulin" value="{{ old('serum_insulin') }}" required>

                @if ($errors->has('serum_insulin'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('serum_insulin') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('bmi') ? ' has-danger' : '' }}">
            <label for="bmi" class="col-4 col-form-label text-right">Body Mass Index</label>

            <div class="col-6">
                <input id="bmi" type="number" step="0.0001" class="form-control" name="bmi" value="{{ old('bmi') }}" required>

                @if ($errors->has('bmi'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('bmi') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('dpf') ? ' has-danger' : '' }}">
            <label for="dpf" class="col-4 col-form-label text-right">Diabetes Pedigree Function</label>

            <div class="col-6">
                <input id="dpf" type="number" step="0.0001" class="form-control" name="dpf" value="{{ old('dpf') }}" required>

                @if ($errors->has('dpf'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('dpf') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary">
                    Evaluate
                </button>
            </div>
        </div>
    </form>
    @endcomponent
@endsection