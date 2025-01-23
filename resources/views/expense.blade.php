<x-layout>
    <!-- Add Expense Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-regular fa-credit-card"></i>&nbsp;Add Expense</h5>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="expenseForm" action="{{route('storeExpense')}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="expenseSource">Expense</label>
                        <input type="text" class="form-control" id="expenseSource" placeholder="e.g., Expenses Account"
                               name="source">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="expenseAmount">Amount</label>
                        <input type="number" class="form-control" id="expenseAmount" placeholder="e.g., 300"
                               name="amount">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="expenseDate">Date</label>
                        <input type="month" class="form-control" id="expenseDate"
                               name="date">
                    </div>
                </div>
                <button type="submit" class="btn gradient-btn" id="addExpense">Add Expense</button>
            </form>
        </div>
    </div>
</x-layout>
