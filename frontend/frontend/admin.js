const API = "../backend/api.php";
const TOKEN_KEY = "yearbook_token";
const ADMIN_LANG_KEY = "mera_admin_lang";
const $ = (id)=>document.getElementById(id);
let lang = localStorage.getItem(ADMIN_LANG_KEY) || "tr";
const I18N = {
  tr:{
    adminPanel:"Admin Paneli", loginIntro:"Sistemi yönetmek için admin hesabıyla giriş yap.", email:"E-posta", password:"Şifre", login:"Giriş Yap", defaultPassHint:"İlk kurulum varsayılan şifresi: Admin123!@#. Girişten sonra hemen değiştir.", language:"Dil", dashboard:"Dashboard", users:"Kullanıcılar", reports:"Raporlar", badgeRequests:"Rozet Talepleri", badwordLogs:"Küfür Logları", info:"Bilgilendirme", security:"Şifre Ayarı", contentReview:"İçerik Takibi", backToSite:"Siteye Dön", logout:"Çıkış", search:"Ara", user:"Kullanıcı", school:"Okul", status:"Durum", action:"İşlem", openReports:"Açık raporlar", closedReports:"Kapalı raporlar", deletedReports:"Silinen şikayetler", refresh:"Yenile", logsDesc:"Sistemin otomatik sansürlediği son 200 kayıt. Tekrarlayan kullanımda admine bildirim gider.", badwordListTitle:"Yasaklı kelime listesi", badwordListDesc:"Sistemdeki argo/yasaklı kelimeleri buradan görüntüleyebilir ve yeni kelime ekleyebilirsin.", addWord:"Ekle", wordCount:"Listedeki kelime sayısı", infoTitle:"Admin Bilgilendirme", infoIntro:"Bu bölüm paneldeki ceza ve moderasyon terimlerini sade şekilde açıklar.", infoMute:"Mute, kullanıcının belirli süre mesaj/gönderi gibi etkileşimleri yapmasının engellenmesidir. Hesap silinmez, süre bitince tekrar kullanabilir.", infoBan:"Ban, kullanıcının uygulamaya erişiminin kapatılmasıdır. Ağır veya tekrarlayan ihlallerde kullanılmalıdır.", infoReportTitle:"Rapor / Şikayet", infoReport:"Açık rapor admin tarafından incelenmemiştir. Problem çözüldü olarak işaretlenince rapor kapanır ve ilgili öğrencilere bildirim gider.", infoBadwordTitle:"Argo / Yasaklı Kelime", infoBadword:"Kullanıcı argo kelime yazarsa metin otomatik sansürlenir ve kullanıcıya uyarı bildirimi gider. Tekrar ederse admin paneline bildirim düşer; admin mute, ban veya sadece takip kararı verebilir.", securityTitle:"Admin Şifre Ayarı", securityDesc:"Admin şifresinin kaç ayda bir yenilenmesi gerektiğini seç. 1, 3 veya 6 ay seçilebilir.", interval:"Şifre yenileme süresi", oneMonth:"Her 1 ay", threeMonths:"Her 3 ay", sixMonths:"Her 6 ay", currentPassword:"Mevcut şifre", newPassword:"Yeni şifre", newPasswordAgain:"Yeni şifre tekrar", adminCallSetting:"Admin arama durumu", adminCallAllowedOn:"Aranabilir", adminCallAllowedOff:"Aranamaz", adminCallDesc:"Aranamaz seçilirse kullanıcılar admin hesabına sesli/görüntülü arama başlatamaz.", adminDmMuteSetting:"Admin DM sessiz durumu", adminDmMuteOff:"DM bildirimleri açık", adminDmMuteOn:"Tüm kullanıcılar sessizde", adminDmMuteDesc:"Açılırsa kullanıcıların admin hesabına gönderdiği DM mesajları bildirim düşürmez.", save:"Kaydet",
    pageDashboard:"Genel sistem durumu", pageUsers:"Ban, mute, admin ve rozet işlemleri", pageReports:"Kullanıcıların bildirdiği içerikler", pageBadges:"Kullanıcıların rozet başvuruları", pageContent:"Dedikodu, Eski Toprak ve anket geçmişi", pageLogs:"Otomatik sansür kayıtları", pageSecurity:"Admin şifresi ve yenileme periyodu", pageInfo:"Ceza ve moderasyon terimleri",
    noInfo:"Bilgi yok.", selectedInterval:"Seçili süre", lastChange:"Son değişim", expires:"Son tarih", daysLeft:"Kalan gün", passwordExpired:"Admin şifre yenileme süresi dolmuş. Lütfen <b>Şifre Ayarı</b> bölümünden yeni şifre belirle.", jsonError:"Sunucudan JSON gelmedi: ", error:"Hata", onlyAdmin:"Bu sayfa sadece admin hesapları içindir.", notAdmin:"Bu hesap admin değil.", stats:{users:"Kullanıcı",farewells:"Veda Mesajı",legacy_messages:"Legacy Mesaj",dm_messages:"DM Mesaj",meetups:"Etkinlik",reports_open:"Açık Rapor",notifications:"Bildirim",banned:"Banlı",muted:"Mute"},
    active:"Aktif", banned:"Banlı", unban:"Ban Kaldır", ban:"Banla", mute30:"30 dk Mute", unmute:"Mute Kaldır", makeAdmin:"Admin Yap", removeAdmin:"Adminliği Al", verify:"Rozet Ver", unverify:"Rozeti Al", tempAdmin:"Geçici Admin", tempAdminPrompt:"Geçici admin süresini yaz: örn. 1 saat, 2 gün, 1 hafta veya 60 dakika.", noUsers:"Kullanıcı bulunamadı.", reportedCount:"Bu kullanıcıya gelen rapor", studentDeleted:"Öğrenci şikayeti 3 gün içinde silmiş.", solved:"Problem çözüldü", deleteContent:"İçeriği Sil", markSolved:"Problem çözüldü olarak işaretle", reporter:"Raporlayan", reported:"Şikayet edilen", noReason:"Sebep yazılmamış", adminNote:"Admin notu", noReports:"Rapor yok.", resolutionPrompt:"Bu rapor için çözüm notu:", original:"Orijinal", censored:"Sansürlü", noLogs:"Kayıt yok.", muteUser:"Kullanıcıyı 30 dk mute et", banUser:"Kullanıcıyı banla", trackOnly:"Sadece takip et", saved:"Kaydedildi.", passwordsMismatch:"Yeni şifreler aynı değil.", sendUserMessage:"Kullanıcıya mesaj gönder", userMessagePrompt:"Şikayet edilen kişiye gönderilecek mesaj:", messageSent:"Mesaj gönderildi.", wordAdded:"Kelime eklendi.", wordDeleted:"Kelime silindi.", listLoadError:"Liste yüklenemedi.", contentDesc:"Dedikodu, Eski Toprak mesajları ve anketleri buradan takip edebilirsin.", gossipPosts:"Dedikodular", legacyMessages:"Eski Toprak", polls:"Anketler", noContent:"İçerik yok.", contentOwner:"Paylaşan", contentMeta:"Tür"
  },
  en:{
    adminPanel:"Admin Panel", loginIntro:"Log in with an admin account to manage the system.", email:"Email", password:"Password", login:"Log In", defaultPassHint:"Default first setup password: Admin123!@#. Change it right after logging in.", language:"Language", dashboard:"Dashboard", users:"Users", reports:"Reports", badgeRequests:"Badge Requests", badwordLogs:"Profanity Logs", info:"Information", security:"Password Settings", contentReview:"Content Review", backToSite:"Back to Site", logout:"Logout", search:"Search", user:"User", school:"School", status:"Status", action:"Action", openReports:"Open reports", closedReports:"Closed reports", deletedReports:"Deleted reports", refresh:"Refresh", logsDesc:"The latest 200 automatically censored records. Repeated usage notifies admins.", badwordListTitle:"Forbidden word list", badwordListDesc:"View slang/forbidden words and add new words here.", addWord:"Add", wordCount:"Word count", infoTitle:"Admin Information", infoIntro:"This section explains moderation and sanction terms in simple language.", infoMute:"Mute prevents a user from sending messages/posts or similar interactions for a limited time. The account is not deleted and works again when the time ends.", infoBan:"Ban closes the user's access to the app. It should be used for serious or repeated violations.", infoReportTitle:"Report / Complaint", infoReport:"An open report has not been reviewed by an admin yet. When it is marked solved, the report closes and related students receive notifications.", infoBadwordTitle:"Slang / Forbidden Words", infoBadword:"When a user writes a forbidden word, the text is automatically censored and the user receives a warning. If it repeats, admins are notified; the admin can decide to mute, ban, or only monitor.", securityTitle:"Admin Password Settings", securityDesc:"Choose how often the admin password must be renewed. 1, 3, or 6 months can be selected.", interval:"Password renewal interval", oneMonth:"Every 1 month", threeMonths:"Every 3 months", sixMonths:"Every 6 months", currentPassword:"Current password", newPassword:"New password", newPasswordAgain:"Repeat new password", adminCallSetting:"Admin call status", adminCallAllowedOn:"Callable", adminCallAllowedOff:"Not callable", adminCallDesc:"When disabled, users cannot start voice/video calls to the admin account.", adminDmMuteSetting:"Admin DM mute status", adminDmMuteOff:"DM notifications on", adminDmMuteOn:"Mute all users", adminDmMuteDesc:"When enabled, DMs sent by users to the admin account do not create notifications.", save:"Save",
    pageDashboard:"General system status", pageUsers:"Ban, mute, admin, and badge actions", pageReports:"Content reported by users", pageBadges:"User badge applications", pageContent:"Gossip, Legacy, and poll history", pageLogs:"Automatic censorship records", pageSecurity:"Admin password and renewal interval", pageInfo:"Sanction and moderation terms",
    noInfo:"No information.", selectedInterval:"Selected interval", lastChange:"Last change", expires:"Expires", daysLeft:"Days left", passwordExpired:"Admin password renewal period has expired. Please set a new password under <b>Password Settings</b>.", jsonError:"Server did not return JSON: ", error:"Error", onlyAdmin:"This page is only for admin accounts.", notAdmin:"This account is not an admin.", stats:{users:"Users",farewells:"Farewell Messages",legacy_messages:"Legacy Messages",dm_messages:"DM Messages",meetups:"Events",reports_open:"Open Reports",notifications:"Notifications",banned:"Banned",muted:"Muted"},
    active:"Active", banned:"Banned", unban:"Unban", ban:"Ban", mute30:"Mute 30 min", unmute:"Unmute", makeAdmin:"Make Admin", removeAdmin:"Remove Admin", verify:"Verify", unverify:"Remove Badge", tempAdmin:"Temporary Admin", tempAdminPrompt:"Enter temporary admin duration, e.g. 1 hour, 2 days, 1 week, or 60 minutes.", noUsers:"No users found.", reportedCount:"Reports for this user", studentDeleted:"The student deleted this complaint within 3 days.", solved:"Problem solved", deleteContent:"Delete Content", markSolved:"Mark as solved", reporter:"Reporter", reported:"Reported user", noReason:"No reason written", adminNote:"Admin note", noReports:"No reports.", resolutionPrompt:"Resolution note for this report:", original:"Original", censored:"Censored", noLogs:"No records.", muteUser:"Mute user for 30 min", banUser:"Ban user", trackOnly:"Monitor only", saved:"Saved.", passwordsMismatch:"New passwords do not match.", sendUserMessage:"Send message to user", userMessagePrompt:"Message to send to the reported user:", messageSent:"Message sent.", wordAdded:"Word added.", wordDeleted:"Word deleted.", listLoadError:"List could not be loaded.", contentDesc:"Review gossip, Legacy messages, and polls here.", gossipPosts:"Gossip", legacyMessages:"Legacy", polls:"Polls", noContent:"No content.", contentOwner:"Owner", contentMeta:"Type"
  }
};
const tr = ()=>I18N[lang] || I18N.tr;
const pages = {
  dashboard: {el:$('pageDashboard'), title:'dashboard', sub:'pageDashboard'},
  users: {el:$('pageUsers'), title:'users', sub:'pageUsers'},
  reports: {el:$('pageReports'), title:'reports', sub:'pageReports'},
  badges: {el:$('pageBadges'), title:'badgeRequests', sub:'pageBadges'},
  content: {el:$('pageContent'), title:'contentReview', sub:'pageContent'},
  logs: {el:$('pageLogs'), title:'badwordLogs', sub:'pageLogs'},
  info: {el:$('pageInfo'), title:'info', sub:'pageInfo'},
  security: {el:$('pageSecurity'), title:'security', sub:'pageSecurity'},
};
function token(){return localStorage.getItem(TOKEN_KEY)||''}
function setToken(t){t?localStorage.setItem(TOKEN_KEY,t):localStorage.removeItem(TOKEN_KEY)}
function esc(s){return String(s??'').replace(/[&<>'"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c]))}
function msg(el,text,type=''){ if(el){ el.textContent=text||''; el.className='msg '+type; } }
async function api(action, method='GET', body=null){
  const qs = method==='GET' && body ? '&'+new URLSearchParams(body).toString() : '';
  const headers={}; if(token()) headers.Authorization=`Bearer ${token()}`;
  const opt={method,headers,cache:'no-store'};
  if(method!=='GET' && body){headers['Content-Type']='application/json'; opt.body=JSON.stringify(body);}
  const res=await fetch(`${API}?action=${encodeURIComponent(action)}${qs}&_=${Date.now()}`,opt);
  const text=await res.text(); let data;
  try{data=JSON.parse(text)}catch(e){throw new Error(tr().jsonError+text.slice(0,180))}
  if(!data.ok) throw new Error(data.error||tr().error);
  return data;
}
function applyLanguage(){
  document.documentElement.lang = lang;
  localStorage.setItem(ADMIN_LANG_KEY, lang);
  ['adminLang','adminLangApp'].forEach(id=>{ const el=$(id); if(el) el.value=lang; });
  document.querySelectorAll('[data-i18n]').forEach(el=>{ const key=el.dataset.i18n; if(tr()[key]) el.textContent=tr()[key]; });
  if($('loginPassword')) $('loginPassword').placeholder = lang==='en' ? 'Admin password' : 'Admin şifresi';
  if($('userSearch')) $('userSearch').placeholder = lang==='en' ? 'Search name, email, or school' : 'Ad, e-posta veya okul ara';
  if($('newPassword')) $('newPassword').placeholder = lang==='en' ? 'Leave blank to only change interval' : 'Boş bırakırsan sadece süre değişir';
  const active=document.querySelector('.nav[data-page].active'); if(active) setPageTitles(active.dataset.page);
}
function setPageTitles(name){ $('pageTitle').textContent=tr()[pages[name].title]; $('pageSub').textContent=tr()[pages[name].sub]; }
function showLogin(){ $('loginView').classList.remove('hidden'); $('appView').classList.add('hidden'); }
function showApp(){ $('loginView').classList.add('hidden'); $('appView').classList.remove('hidden'); }
function renderPasswordStatus(st){
  if(!st) return tr().noInfo;
  return `${tr().selectedInterval}: <b>${st.interval_months} ${lang==='en'?'months':'ay'}</b><br>${tr().lastChange}: <b>${esc(st.changed_at)}</b><br>${tr().expires}: <b>${esc(st.expires_at)}</b><br>${tr().daysLeft}: <b>${st.days_left}</b>`;
}
function checkPasswordWarning(st){ const box=$('passwordWarning'); if(st && st.expired){ box.innerHTML=tr().passwordExpired; box.classList.remove('hidden'); } else box.classList.add('hidden'); }
async function init(){ applyLanguage(); if(!token()) return showLogin(); try{ const me=await api('me'); if(!me.user || !me.user.is_admin) throw new Error(tr().onlyAdmin); $('adminEmail').textContent=me.user.email||'admin'; if($('adminSelfName')) $('adminSelfName').value=me.user.full_name||''; showApp(); checkPasswordWarning(me.admin_password); await openPage('dashboard'); }catch(e){ setToken(''); showLogin(); msg($('loginMsg'),e.message,'err'); } }
async function openPage(name){ if(!pages[name]) name='dashboard'; Object.values(pages).forEach(p=>p.el&&p.el.classList.add('hidden')); pages[name].el.classList.remove('hidden'); setPageTitles(name); document.querySelectorAll('.nav[data-page]').forEach(b=>b.classList.toggle('active',b.dataset.page===name)); if(name==='dashboard') await loadDashboard(); if(name==='users') await loadUsers(); if(name==='reports') await loadReports(); if(name==='badges') await loadBadgeRequests(); if(name==='content') await loadContent(); if(name==='logs'){ await loadBadwords(); await loadLogs(); } if(name==='security') await loadSecurity(); }
async function loadDashboard(){ const d=await api('admin_dashboard'); checkPasswordWarning(d.admin_password); $('statsGrid').innerHTML=Object.entries(d.stats||{}).filter(([k])=>k!=='gossip_posts').map(([k,v])=>`<div class="stat"><b>${v}</b><span>${tr().stats[k]||k}</span></div>`).join(''); }


let tempAdminTargetUserId = null;

function formatDurationMinutes(minutes){
  minutes = Math.max(1, Math.round(Number(minutes)||0));
  if(minutes % 10080 === 0) return `${minutes/10080} hafta`;
  if(minutes % 1440 === 0) return `${minutes/1440} gün`;
  if(minutes % 60 === 0) return `${minutes/60} saat`;
  return `${minutes} dakika`;
}

function tempAdminMinutesFromControls(){
  const amount = Math.max(1, Number($('tempAdminAmount')?.value || 1));
  const unit = Math.max(1, Number($('tempAdminUnit')?.value || 60));
  return Math.round(amount * unit);
}

function updateTempAdminPreview(){
  const el = $('tempAdminPreview');
  if(el) el.textContent = `Seçilen süre: ${formatDurationMinutes(tempAdminMinutesFromControls())}`;
}

function openTempAdminModal(userId){
  tempAdminTargetUserId = Number(userId);
  const modal = $('tempAdminModal');
  if($('tempAdminAmount')) $('tempAdminAmount').value = '1';
  if($('tempAdminUnit')) $('tempAdminUnit').value = '60';
  updateTempAdminPreview();
  if(modal){ modal.classList.remove('hidden'); modal.setAttribute('aria-hidden','false'); }
}

function closeTempAdminModal(){
  tempAdminTargetUserId = null;
  const modal = $('tempAdminModal');
  if(modal){ modal.classList.add('hidden'); modal.setAttribute('aria-hidden','true'); }
}

function initTempAdminModal(){
  const amount = $('tempAdminAmount');
  const unit = $('tempAdminUnit');
  if(amount) amount.oninput = updateTempAdminPreview;
  if(unit) unit.onchange = updateTempAdminPreview;
  const plus = $('btnTempAdminPlus');
  const minus = $('btnTempAdminMinus');
  if(plus) plus.onclick = ()=>{ amount.value = String(Math.min(365, Math.max(1, Number(amount.value||1)+1))); updateTempAdminPreview(); };
  if(minus) minus.onclick = ()=>{ amount.value = String(Math.max(1, Number(amount.value||1)-1)); updateTempAdminPreview(); };
  document.querySelectorAll('[data-temp-preset]').forEach(btn=>{
    btn.onclick = ()=>{
      const mins = Number(btn.dataset.tempPreset||60);
      if(mins % 10080 === 0){ unit.value='10080'; amount.value=String(mins/10080); }
      else if(mins % 1440 === 0){ unit.value='1440'; amount.value=String(mins/1440); }
      else if(mins % 60 === 0){ unit.value='60'; amount.value=String(mins/60); }
      else { unit.value='1'; amount.value=String(mins); }
      updateTempAdminPreview();
    };
  });
  ['btnTempAdminClose','btnTempAdminCancel'].forEach(id=>{ const b=$(id); if(b) b.onclick=closeTempAdminModal; });
  const modal = $('tempAdminModal');
  if(modal) modal.onclick = (e)=>{ if(e.target === modal) closeTempAdminModal(); };
  const confirm = $('btnTempAdminConfirm');
  if(confirm) confirm.onclick = async ()=>{
    try{
      if(!tempAdminTargetUserId) return;
      const minutes = tempAdminMinutesFromControls();
      await api('admin_user_update','POST',{user_id:tempAdminTargetUserId,temp_admin_minutes:minutes});
      closeTempAdminModal();
      await loadUsers();
    }catch(e){ alert(e.message || 'Geçici admin verilemedi.'); }
  };
}

function tempRemainingText(raw){
  if(!raw) return '';
  const iso = String(raw).includes('T') ? String(raw) : String(raw).replace(' ', 'T') + 'Z';
  const diff = new Date(iso).getTime() - Date.now();
  if(!Number.isFinite(diff) || diff <= 0) return 'süre doldu';
  const total = Math.floor(diff/1000);
  const d = Math.floor(total/86400);
  const h = Math.floor((total%86400)/3600);
  const m = Math.floor((total%3600)/60);
  const s = total%60;
  if(d>0) return `${d}g ${h}s ${m}dk`;
  if(h>0) return `${h}s ${m}dk`;
  if(m>0) return `${m}dk ${s}sn`;
  return `${s}sn`;
}

function refreshAdminCountdowns(){
  document.querySelectorAll('[data-admin-countdown]').forEach(el=>{
    el.textContent = `Kalan: ${tempRemainingText(el.dataset.adminCountdown)}`;
  });
}

async function loadUsers(){ const q=$('userSearch').value.trim(); const d=await api('admin_users','GET',{q,limit:120}); $('usersBody').innerHTML=(d.users||[]).map(u=>{
  const temp = u.admin_until ? `<span class="pill warn" data-admin-countdown="${esc(u.admin_until)}">Kalan: ${tempRemainingText(u.admin_until)}</span>` : '';
  const adminBadge = u.is_admin ? `<span class="pill good">Admin</span>${temp}` : '';
  return `<tr><td>#${u.id}</td><td><b>${esc(u.full_name)}</b><br><span class="muted">${esc(u.email)}</span></td><td>${esc(u.school||'-')}<br><span class="muted">${esc(u.class_label||'')} ${u.grad_year||''}</span></td><td>${adminBadge}${u.verified_badge?'<span class="pill good">Verified</span>':''}${u.is_banned?`<span class="pill bad">${tr().banned}</span>`:`<span class="pill">${tr().active}</span>`}${u.mute_until?`<span class="pill bad">Mute: ${esc(u.mute_until)}</span>`:''}</td><td><div class="row-actions"><button data-act="ban" data-id="${u.id}" data-val="${u.is_banned?0:1}">${u.is_banned?tr().unban:tr().ban}</button><button data-act="mute" data-id="${u.id}">${tr().mute30}</button><button data-act="unmute" data-id="${u.id}">${tr().unmute}</button><button data-act="admin" data-id="${u.id}" data-val="${u.is_admin?0:1}">${u.is_admin?tr().removeAdmin:tr().makeAdmin}</button><button data-act="tempadmin" data-id="${u.id}">${tr().tempAdmin}</button><button data-act="verify" data-id="${u.id}" data-val="${u.verified_badge?0:1}">${u.verified_badge?tr().unverify:tr().verify}</button></div></td></tr>`;
}).join('') || `<tr><td colspan="5" class="muted">${tr().noUsers}</td></tr>`; document.querySelectorAll('[data-act]').forEach(btn=>btn.onclick=()=>userAction(btn)); }
async function userAction(btn){
  try{
    const id=Number(btn.dataset.id); const act=btn.dataset.act; let body={user_id:id};
    if(act==='ban') body.is_banned=Number(btn.dataset.val);
    if(act==='mute') body.mute_minutes=30;
    if(act==='unmute') body.mute_minutes=0;
    if(act==='admin') body.is_admin=Number(btn.dataset.val);
    if(act==='tempadmin'){ openTempAdminModal(id); return; }
    if(act==='verify') body.verified_badge=Number(btn.dataset.val);
    await api('admin_user_update','POST',body);
    await loadUsers();
  }catch(e){ alert(e.message); }
}
async function loadReports(){ const d=await api('admin_reports','GET',{status:$('reportStatus').value}); $('reportsList').innerHTML=(d.reports||[]).map(r=>{ const closed=r.status==='closed', deleted=r.status==='deleted'; const note=r.resolution_note?`<div class="status-box"><b>${tr().adminNote}:</b><br>${esc(r.resolution_note)}</div>`:''; const risk=r.reported_user_id?`<span class="pill ${Number(r.reported_report_count)>=3?'bad':''}">${tr().reportedCount}: ${Number(r.reported_report_count||0)}</span>`:''; const actions=deleted?`<span class="muted">${tr().studentDeleted}</span>`:(closed?`<span class="pill good">${tr().solved}</span>`:`<button data-del="${r.target_type}:${r.target_id}">${tr().deleteContent}</button><button data-close="${r.id}">${tr().markSolved}</button>`); return `<div class="card"><div class="card-head"><b>🚩 #${r.id} ${esc(r.target_type)}:${r.target_id}</b><span class="muted">${esc(r.created_at)}</span></div><div class="muted">${tr().reporter}: ${esc(r.reporter_name)}${r.reported_name?` • ${tr().reported}: ${esc(r.reported_name)}`:''}</div><div style="margin-top:8px">${risk}</div><p>${esc(r.reason||tr().noReason)}</p>${note}<div class="row-actions">${actions}</div></div>`; }).join('') || `<p class="muted">${tr().noReports}</p>`; document.querySelectorAll('[data-del]').forEach(b=>b.onclick=async()=>{const [target_type,target_id]=b.dataset.del.split(':'); await api('admin_delete','POST',{target_type,target_id:Number(target_id)}); await loadReports();}); document.querySelectorAll('[data-close]').forEach(b=>b.onclick=async()=>{const note=window.prompt(tr().resolutionPrompt, tr().solved); if(note===null) return; await api('admin_report_close','POST',{id:Number(b.dataset.close), resolution_note:note}); await loadReports();}); }


async function loadBadgeRequests(){
  const list = $('badgeRequestsList');
  if(!list) return;
  try{
    const d = await api('admin_badge_requests','GET',{status:$('badgeStatus')?.value || 'pending'});
    const rows = d.items || [];
    list.innerHTML = rows.map(x=>`<div class="card">
      <div class="card-head"><b>🏅 #${x.id} ${esc(x.full_name||'-')}</b><span class="muted">${esc(x.created_at||'')}</span></div>
      <div class="muted">${esc(x.email||'-')} • ${esc(x.school||'-')} ${x.grad_year||''}</div>
      <div class="badgeRequestMeta"><span class="pill ${x.status==='approved'?'good':(x.status==='rejected'?'bad':'')}">${esc(x.status)}</span>${Number(x.verified_badge||0)===1?'<span class="pill good">Rozetli</span>':''}</div>
      <div class="badgeRequestBody">${esc(x.message||'')}</div>
      ${x.admin_note ? `<div class="status-box"><b>Admin notu:</b><br>${esc(x.admin_note)}</div>` : ''}
      ${x.status==='pending' ? `<div class="badgeRequestActions"><button class="approve" data-badge-approve="${x.id}">Rozeti Onayla</button><button class="reject" data-badge-reject="${x.id}">Reddet</button></div>` : ''}
    </div>`).join('') || `<p class="muted">Rozet talebi yok.</p>`;
    document.querySelectorAll('[data-badge-approve]').forEach(b=>b.onclick=async()=>{ if(!confirm('Bu kullanıcıya rozet verilsin mi?')) return; await api('admin_badge_request_decide','POST',{id:Number(b.dataset.badgeApprove),decision:'approved'}); await loadBadgeRequests(); });
    document.querySelectorAll('[data-badge-reject]').forEach(b=>b.onclick=async()=>{ const note=window.prompt('Red sebebi / admin notu (opsiyonel):',''); if(note===null) return; await api('admin_badge_request_decide','POST',{id:Number(b.dataset.badgeReject),decision:'rejected',note}); await loadBadgeRequests(); });
  }catch(e){ list.innerHTML = `<p class="msg err">${esc(e.message)}</p>`; }
}

async function loadContent(){
  const type = $('contentType')?.value || 'gossip';
  const list = $('contentList');
  if(!list) return;
  try{
    const d = await api('admin_content','GET',{type,limit:120});
    const rows = d.items || [];
    list.innerHTML = rows.map(x=>`<div class="card">
      <div class="card-head"><b>#${x.id} ${esc(x.title||'')}</b><span class="muted">${esc(x.created_at||'')}</span></div>
      <div class="muted">${tr().contentOwner}: ${esc(x.author||'-')} • ${esc(x.school||'-')} ${x.grad_year||''} • ${tr().contentMeta}: ${esc(x.meta||x.type||'')}</div>
      <p style="white-space:pre-wrap">${esc(x.body||'')}</p>
      <div class="row-actions"><button class="danger" data-content-del="${x.type}:${x.id}">${tr().deleteContent}</button></div>
    </div>`).join('') || `<p class="muted">${tr().noContent}</p>`;
    document.querySelectorAll('[data-content-del]').forEach(b=>b.onclick=async()=>{
      const [rawType,id]=b.dataset.contentDel.split(':');
      const target_type = rawType === 'gossip' ? 'gossip_post' : (rawType === 'legacy' ? 'legacy' : '');
      if(!target_type){ alert('Anketler kayıt olarak tutulur; silme işlemi bu ekranda kapalı.'); return; }
      if(!confirm(tr().deleteContent+'?')) return;
      await api('admin_delete','POST',{target_type,target_id:Number(id)});
      await loadContent();
    });
  }catch(e){ list.innerHTML = `<p class="msg err">${esc(e.message)}</p>`; }
}

function decodeUnicodeEscapes(v){
  return String(v ?? '').replace(/\\u([0-9a-fA-F]{4})/g, (_, h) => String.fromCharCode(parseInt(h, 16)));
}
let badwordCache=[];
function renderBadwords(){
  const q=($('badwordSearch')?.value||'').trim().toLowerCase();
  const normalized=(badwordCache||[]).map(decodeUnicodeEscapes);
  const list=normalized.filter(w=>!q || w.toLowerCase().includes(q));
  if($('badwordCount')) $('badwordCount').textContent=`${tr().wordCount}: ${normalized.length}`;
  if($('badwordList')) $('badwordList').innerHTML=list.map(w=>`<span class="word-chip">${esc(w)} <button title="Sil" data-word-del="${esc(w)}">×</button></span>`).join('') || `<p class="muted">${lang==='en'?'List is empty.':'Liste boş.'}</p>`;
  document.querySelectorAll('[data-word-del]').forEach(b=>b.onclick=async()=>{ if(!confirm(`"${b.dataset.wordDel}" silinsin mi?`)) return; const d=await api('admin_badwords_delete','POST',{word:b.dataset.wordDel}); badwordCache=Array.isArray(d.words)?d.words:[]; renderBadwords(); const m=$('badwordMsg'); if(m) msg(m,tr().wordDeleted,'ok'); });
}
async function loadBadwords(){ try{ const d=await api('admin_badwords_get'); badwordCache=Array.isArray(d.words)?d.words:[]; renderBadwords(); const m=$('badwordMsg'); if(m) msg(m,'',''); }catch(e){ badwordCache=[]; renderBadwords(); const m=$('badwordMsg'); if(m) msg(m,`${tr().listLoadError}: ${e.message}`,'err'); } }
async function addBadword(){ try{ const inp=$('badwordNew'); const word=(inp?.value||'').trim(); if(!word) return; const d=await api('admin_badwords_add','POST',{word}); badwordCache=Array.isArray(d.words)?d.words:[]; inp.value=''; renderBadwords(); const m=$('badwordMsg'); if(m) msg(m,tr().wordAdded,'ok'); }catch(e){ const m=$('badwordMsg'); if(m) msg(m,e.message,'err'); else alert(e.message); } }

async function loadLogs(){ const d=await api('admin_badword_logs'); $('logsList').innerHTML=(d.logs||[]).map(x=>`<div class="card"><div class="card-head"><b>${esc(x.full_name)} • ${esc(x.context)}</b><span class="muted">${esc(x.created_at)}</span></div><div class="muted">${tr().original}</div><p>${esc(x.original_text)}</p><div class="muted">${tr().censored}</div><p>${esc(x.censored_text)}</p><div class="row-actions"><button data-logmute="${x.user_id}">${tr().muteUser}</button><button class="danger" data-logban="${x.user_id}">${tr().banUser}</button><button disabled>${tr().trackOnly}</button></div></div>`).join('') || `<p class="muted">${tr().noLogs}</p>`; document.querySelectorAll('[data-logmute]').forEach(b=>b.onclick=async()=>{ await api('admin_user_update','POST',{user_id:Number(b.dataset.logmute),mute_minutes:30}); await loadLogs(); }); document.querySelectorAll('[data-logban]').forEach(b=>b.onclick=async()=>{ await api('admin_user_update','POST',{user_id:Number(b.dataset.logban),is_banned:1}); await loadLogs(); }); }
async function loadSecurity(){ const d=await api('admin_security'); checkPasswordWarning(d.admin_password); $('intervalMonths').value=String(d.admin_password.interval_months||3); if($('adminCallAllowedSelect')) $('adminCallAllowedSelect').value=String(d.admin_call_allowed ?? 1); if($('adminDmMutedAllSelect')) $('adminDmMutedAllSelect').value=String(d.admin_dm_muted_all ?? 0); $('securityStatus').innerHTML=renderPasswordStatus(d.admin_password); }
$('btnLogin').onclick=async()=>{try{msg($('loginMsg'),''); const d=await api('login','POST',{email:$('loginEmail').value.trim(),password:$('loginPassword').value}); if(!d.user?.is_admin) throw new Error(tr().notAdmin); setToken(d.token); $('adminEmail').textContent=d.user.email; if($('adminSelfName')) $('adminSelfName').value=d.user.full_name||''; showApp(); checkPasswordWarning(d.admin_password); await openPage('dashboard');}catch(e){msg($('loginMsg'),e.message,'err')}};
$('btnLogout').onclick=async()=>{try{await api('logout','POST',{})}catch(e){} setToken(''); showLogin();};
document.querySelectorAll('.nav[data-page]').forEach(b=>b.onclick=()=>openPage(b.dataset.page));
$('btnUserSearch').onclick=loadUsers; $('userSearch').onkeydown=e=>{if(e.key==='Enter')loadUsers();};
$('btnReportsReload').onclick=loadReports; $('reportStatus').onchange=loadReports; if($('btnBadgesReload')) $('btnBadgesReload').onclick=loadBadgeRequests; if($('badgeStatus')) $('badgeStatus').onchange=loadBadgeRequests; if($('btnContentReload')) $('btnContentReload').onclick=loadContent; if($('contentType')) $('contentType').onchange=loadContent; if($('btnBadwordAdd')) $('btnBadwordAdd').onclick=addBadword; if($('badwordSearch')) $('badwordSearch').oninput=renderBadwords;
$('btnSaveSecurity').onclick=async()=>{try{msg($('securityMsg'),''); const np=$('newPassword').value,n2=$('newPassword2').value; if(np!==n2) throw new Error(tr().passwordsMismatch); const d=await api('admin_update_security','POST',{current_password:$('currentPassword').value,new_password:np,interval_months:Number($('intervalMonths').value),admin_call_allowed:Number($('adminCallAllowedSelect')?.value ?? 1),admin_dm_muted_all:Number($('adminDmMutedAllSelect')?.value ?? 0)}); $('currentPassword').value=$('newPassword').value=$('newPassword2').value=''; $('securityStatus').innerHTML=renderPasswordStatus(d.admin_password); checkPasswordWarning(d.admin_password); msg($('securityMsg'),tr().saved,'ok');}catch(e){msg($('securityMsg'),e.message,'err')}};
['adminLang','adminLangApp'].forEach(id=>{ const el=$(id); if(el) el.onchange=()=>{ lang=el.value; applyLanguage(); const active=document.querySelector('.nav[data-page].active'); if(active) openPage(active.dataset.page); }; });
initTempAdminModal();
setInterval(refreshAdminCountdowns, 1000);
init();

const btnAdminSelfName = $('btnAdminSelfName');
if(btnAdminSelfName){
  btnAdminSelfName.onclick = async ()=>{
    try{
      const name = ($('adminSelfName')?.value || '').trim();
      if(!name) return alert('Admin görünen adı boş olamaz.');
      const d = await api('admin_update_self_name','POST',{full_name:name});
      if(d.user){ $('adminEmail').textContent = d.user.email || 'admin'; $('adminSelfName').value = d.user.full_name || name; }
      const active=document.querySelector('.nav[data-page].active'); if(active?.dataset.page==='users') await loadUsers();
    }catch(e){ alert(e.message || 'Güncellenemedi.'); }
  };
}
