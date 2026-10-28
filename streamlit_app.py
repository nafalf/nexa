import streamlit as st
from datetime import datetime

st.set_page_config(page_title='Nexa', page_icon=None, layout='centered', initial_sidebar_state='collapsed')

ORANGE='#FF8138'; TURQUOISE='#72D4D0'; LIME='#E1F84A'; BLUE='#9BB4FF'

def gaya():
    st.markdown(f'''<style>
    .stApp{{background:#fbfbfb;color:#111}} .block-container{{max-width:620px;padding:2rem 1.2rem 6rem}}
    h1,h2,h3,p,div,button{{font-family:Arial,sans-serif}} h1{{letter-spacing:-1px}}
    .brand{{font-size:2.2rem;font-weight:800;color:{ORANGE};letter-spacing:-2px;margin-bottom:2rem}}
    .brand span{{display:inline-block;width:10px;height:10px;background:{TURQUOISE};border-radius:50%;margin-right:5px}}
    .card{{background:white;border:1px solid #ededed;border-radius:22px;padding:1.2rem;margin:1rem 0}}
    .balance{{background:{ORANGE};border-radius:22px;padding:1.4rem;margin:1rem 0;color:#111}}
    .balance small,.balance strong{{display:block}} .balance strong{{font-size:2rem;margin-top:.4rem}}
    .chip{{display:inline-block;background:white;border-radius:20px;padding:.35rem .7rem;font-size:.75rem;font-weight:700;float:right}}
    .section{{display:flex;justify-content:space-between;align-items:center;margin-top:1.6rem}}
    .section h3{{margin:0}} .muted{{color:#777}} .feature{{background:{TURQUOISE};border-radius:18px;padding:1rem .4rem;text-align:center;min-height:80px}}
    .feature-orange{{background:{ORANGE}}} .feature-blue{{background:{BLUE}}} .transaction{{border-bottom:1px solid #eee;padding:.9rem 0;display:flex;justify-content:space-between}}
    .nav{{display:flex;justify-content:space-around;position:fixed;bottom:0;left:50%;transform:translateX(-50%);max-width:620px;width:100%;background:#fff;border-top:1px solid #eee;padding:1rem;z-index:5}}
    .nav a{{color:#777;text-decoration:none;text-align:center;font-size:.78rem}} .nav a.active{{color:{ORANGE};font-weight:700}}
    </style>''', unsafe_allow_html=True)

def data_awal():
    if 'saldo' not in st.session_state: st.session_state.saldo=28000000
    if 'transaksi' not in st.session_state: st.session_state.transaksi=[{'judul':'Transfer ke Yogie','waktu':'Hari ini, 09:12','nominal':-250000},{'judul':'Pembayaran masuk','waktu':'Kemarin, 16:40','nominal':1500000}]
    if 'masuk' not in st.session_state: st.session_state.masuk=False

def navigasi(halaman):
    st.markdown(f'''<div class="nav"><a class="{'active' if halaman=='Beranda' else ''}" href="?halaman=Beranda">Beranda</a><a class="{'active' if halaman=='Aktivitas' else ''}" href="?halaman=Aktivitas">Aktivitas</a><a class="{'active' if halaman=='Transfer' else ''}" href="?halaman=Transfer">Transfer</a><a class="{'active' if halaman=='Profil' else ''}" href="?halaman=Profil">Profil</a></div>''', unsafe_allow_html=True)

def login():
    st.markdown('<div class="brand"><span></span>nexa</div>', unsafe_allow_html=True)
    st.caption('Perbankan digital yang lebih sederhana')
    st.title('Selamat datang kembali.')
    email=st.text_input('Email', value='demo@nexa.id'); password=st.text_input('Kata sandi', value='Nexa1234', type='password')
    if st.button('Masuk', use_container_width=True):
        if email=='demo@nexa.id' and password=='Nexa1234': st.session_state.masuk=True; st.rerun()
        else: st.error('Email atau kata sandi tidak sesuai.')
    st.markdown('Atau lihat aplikasi tanpa masuk.')
    if st.button('Buka demo', use_container_width=True): st.session_state.masuk=True; st.session_state.demo=True; st.rerun()

def beranda(demo=False):
    st.markdown('<div class="brand"><span></span>nexa</div>', unsafe_allow_html=True)
    st.write('Selamat pagi, Ardi.')
    st.markdown(f'<div class="balance"><span class="chip">UTAMA</span><small>Nexa Tabungan · 0223 3838 30</small><strong>Rp{st.session_state.saldo:,.0f}</strong><small>Total saldo</small></div>'.replace(',','.'), unsafe_allow_html=True)
    st.markdown('<div class="section"><h3>Akses cepat</h3></div>',unsafe_allow_html=True)
    c1,c2,c3=st.columns(3)
    with c1: st.markdown('<div class="feature">Transfer</div>',unsafe_allow_html=True)
    with c2: st.markdown('<div class="feature feature-orange">Riwayat</div>',unsafe_allow_html=True)
    with c3: st.markdown('<div class="feature feature-blue">Rekening</div>',unsafe_allow_html=True)
    if demo: st.info('Mode demo aktif. Masuk untuk mencoba transfer.')
    st.markdown('<div class="section"><h3>Transaksi terakhir</h3></div>',unsafe_allow_html=True)
    for t in st.session_state.transaksi[:4]:
        warna='#198754' if t['nominal']>0 else ORANGE
        st.markdown(f'<div class="transaction"><span>{t["judul"]}<br><small class="muted">{t["waktu"]}</small></span><b style="color:{warna}">Rp{abs(t["nominal"]):,.0f}</b></div>'.replace(',','.'),unsafe_allow_html=True)
    navigasi('Beranda')

def aktivitas():
    st.markdown('<div class="brand"><span></span>nexa</div>',unsafe_allow_html=True); st.title('Aktivitas'); st.caption('Semua transaksi dari rekening kamu.')
    for t in st.session_state.transaksi:
        tanda='+' if t['nominal']>0 else '-'; st.markdown(f'<div class="transaction"><span>{t["judul"]}<br><small class="muted">{t["waktu"]}</small></span><b>{tanda} Rp{abs(t["nominal"]):,.0f}</b></div>'.replace(',','.'),unsafe_allow_html=True)
    navigasi('Aktivitas')

def transfer():
    st.markdown('<div class="brand"><span></span>nexa</div>',unsafe_allow_html=True); st.title('Transfer'); st.caption('Gunakan OTP 123456 untuk simulasi.')
    tujuan=st.selectbox('Rekening tujuan',['Yogie · Nexa Bank','Putri · Nexa Bank']); nominal=st.number_input('Nominal',min_value=10000,value=100000,step=10000); otp=st.text_input('OTP simulasi')
    if st.button('Kirim transfer',use_container_width=True):
        if otp!='123456': st.error('OTP tidak sesuai.')
        elif nominal>st.session_state.saldo: st.error('Saldo tidak mencukupi.')
        else: st.session_state.saldo-=nominal; st.session_state.transaksi.insert(0,{'judul':f'Transfer ke {tujuan.split(" · ")[0]}','waktu':'Baru saja','nominal':-nominal}); st.success('Transfer berhasil diproses.')
    navigasi('Transfer')

def profil():
    st.markdown('<div class="brand"><span></span>nexa</div>',unsafe_allow_html=True); st.title('Profil'); st.markdown('<div class="card"><h3>Ardi Pratama</h3><p class="muted">demo@nexa.id</p><hr><p>Rekening utama<br><b>0223 3838 30</b></p><p>Status akun<br><b>Verifikasi aktif</b></p></div>',unsafe_allow_html=True)
    if st.button('Keluar',use_container_width=True): st.session_state.masuk=False; st.rerun()
    navigasi('Profil')

gaya(); data_awal(); halaman=st.query_params.get('halaman','Beranda')
if not st.session_state.masuk: login()
elif halaman=='Aktivitas': aktivitas()
elif halaman=='Transfer': transfer()
elif halaman=='Profil': profil()
else: beranda(demo=st.session_state.get('demo',False))
