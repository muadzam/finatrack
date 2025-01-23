<x-layout>
    <!-- Add Income Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-hand-holding-dollar"></i>&nbsp;Add Income</h5>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="incomeForm" action="{{route('storeIncome')}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="incomeSource">Income</label>
                        <select class="form-control" id="incomeSource" name="source" onchange="handleIncomeSourceChange(this)">
                            <option value="Salary">Salary</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" id="otherSourceField" style="display: none;">
                        <label for="otherIncomeSource">Specify Income Source</label>
                        <input type="text" class="form-control" id="otherIncomeSource" placeholder="Specify income source" name="other_source">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="incomeAmount">Amount</label>
                        <input type="number" class="form-control" id="incomeAmount" placeholder="e.g., 300" name="amount">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="incomeDate">Date</label>
                        <input type="month" class="form-control" id="incomeDate" name="date">
                    </div>
                </div>
                <button type="submit" class="btn gradient-btn" id="addIncome">Add Income</button>
            </form>
        </div>
    </div>
    <script>
        function handleIncomeSourceChange(selectElement) {
            const otherSourceField = document.getElementById('otherSourceField');
            if (selectElement.value === 'Others') {
                otherSourceField.style.display = 'block';
            } else {
                otherSourceField.style.display = 'none';
            }
        }
    </script>
</x-layout>
