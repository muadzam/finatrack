<x-layout>
    <!-- Add Saving Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-vault"></i>&nbsp;Add Saving</h5>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="savingForm" action="{{route('storeSaving')}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="savingSource">Saving</label>
                        <input type="text" class="form-control" id="savingSource" placeholder="e.g., Savings Account"
                               name="source">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="savingAmount">Amount</label>
                        <input type="number" class="form-control" id="savingAmount" placeholder="e.g., 300"
                               name="amount">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="savingDate">Date</label>
                        <input type="month" class="form-control" id="savingDate"
                               name="date">
                    </div>
                </div>
                <button type="submit" class="btn gradient-btn" id="addSaving">Add Saving</button>
            </form>
        </div>
    </div>
</x-layout>
