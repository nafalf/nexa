<?php
namespace App\Http\Controllers;
use App\Models\{Account,Beneficiary,Transaction,User}; use Illuminate\Http\Request; use Illuminate\Support\Facades\{Auth,DB,Hash};
class NexaController extends Controller {
 public function home(){return view('welcome');}
 public function demo(){ $u=User::where('email','demo@nexa.id')->firstOrFail(); return view('dashboard',['user'=>$u,'account'=>$u->accounts()->first(),'beneficiaries'=>$u->beneficiaries,'transactions'=>$u->transactions()->latest()->take(6)->get(),'demoMode'=>true]); }
 public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']); if(Auth::attempt($data)){$r->session()->regenerate();return redirect()->route('dashboard');} return back()->withErrors(['email'=>'Email atau kata sandi tidak sesuai.']);}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
 public function dashboard(){ $u=Auth::user(); return view('dashboard',['user'=>$u,'account'=>$u->accounts()->first(),'beneficiaries'=>$u->beneficiaries,'transactions'=>$u->transactions()->latest()->take(6)->get(),'demoMode'=>false]); }
 public function activity(){ $u=Auth::user(); return view('activity',['user'=>$u,'transactions'=>$u->transactions()->latest()->paginate(12)]); }
 public function transferPage(){ $u=Auth::user(); return view('transfer',['user'=>$u,'account'=>$u->accounts()->first(),'beneficiaries'=>$u->beneficiaries]); }
 public function profile(){ $u=Auth::user(); return view('profile',['user'=>$u,'account'=>$u->accounts()->first()]); }
 public function storeBeneficiary(Request $r){$d=$r->validate(['name'=>'required|string|max:100','bank'=>'required|string|max:50','number'=>'required|string|max:30']);Auth::user()->beneficiaries()->create($d);return back()->with('success','Rekening tujuan berhasil ditambahkan.');}
 public function destroyBeneficiary(Beneficiary $beneficiary){abort_unless($beneficiary->user_id===Auth::id(),403);$beneficiary->delete();return back()->with('success','Rekening tujuan dihapus.');}
 public function transfer(Request $r){$d=$r->validate(['beneficiary_id'=>'required|exists:beneficiaries,id','amount'=>'required|numeric|min:10000','otp'=>'required|digits:6']);$u=Auth::user();$b=$u->beneficiaries()->findOrFail($d['beneficiary_id']);$a=$u->accounts()->firstOrFail();if($d['otp']!=='123456'||$a->balance<$d['amount'])return back()->withErrors(['transfer'=>$d['otp']!=='123456'?'Kode OTP tidak sesuai.':'Saldo tidak mencukupi.']);DB::transaction(function()use($u,$a,$b,$d){$a->decrement('balance',$d['amount']);Transaction::create(['user_id'=>$u->id,'account_id'=>$a->id,'beneficiary_id'=>$b->id,'type'=>'debit','amount'=>$d['amount'],'description'=>'Transfer ke '.$b->name,'reference'=>'NX'.now()->format('ymdHis').random_int(10,99),'suspicious'=>$d['amount']>10000000]);DB::table('audit_logs')->insert(['user_id'=>$u->id,'action'=>'transfer','details'=>'Transfer berhasil','created_at'=>now(),'updated_at'=>now()]);});return back()->with('success','Transfer berhasil diproses.');}
 public function admin(){return view('admin',['users'=>User::count(),'transactions'=>Transaction::count(),'volume'=>Transaction::sum('amount'),'alerts'=>Transaction::where('suspicious',true)->latest()->take(10)->get()]);}
}
