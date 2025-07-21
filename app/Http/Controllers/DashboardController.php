use App\Models\Customer;
use App\Models\Order;
use App\Models\Part;
use App\Models\Employee;

public function index() {
    return view('dashboard', [
        'customers' => Customer::all(),
        'orders' => Order::all(),
        'parts' => Part::all(),
        'employees' => Employee::all(),
    ]);
}