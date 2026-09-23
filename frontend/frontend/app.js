const API = "../backend/api.php";
const TOKEN_KEY = "yearbook_token";
const GRAD_LOCK_KEY = "grad_year_locked_until"; // ms timestamp
const LANG_KEY = "mera_lang";
const FIRST_WELCOME_PREFIX = "mera_first_welcome_seen_";

const $ = (id)=>document.getElementById(id);

const topbar = $("topbar");
const authView = $("authView");
const appView = $("appView");

const tabLogin = $("tabLogin");
const tabRegister = $("tabRegister");
const loginPanel = $("loginPanel");
const registerPanel = $("registerPanel");
const authMsg = $("authMsg");
const regMsg = $("regMsg");
const regPassConfirm = $("regPassConfirm");
const regStrengthLabel = $("regStrengthLabel");
const regStrengthBar = $("regStrengthBar");
const capsLockHint = $("capsLockHint");

const btnLogin = $("btnLogin");
const btnRegister = $("btnRegister");
const btnLogout = $("btnLogout");
const btnAdminPortal = $("btnAdminPortal");
const adminCountdownPill = $("adminCountdownPill");
const meBadge = $("meBadge");
const btnLangTR = $("btnLangTR");
const btnLangEN = $("btnLangEN");
const btnLangTRAuth = $("btnLangTRAuth");
const btnLangENAuth = $("btnLangENAuth");

const btnHome = $("btnHome");
const btnDirectory = $("btnDirectory");
const btnMyProfile = $("btnMyProfile");
const btnPet = $("btnPet");
const btnLegacy = $("btnLegacy");
const btnGossip = $("btnGossip");
const btnDM = $("btnDM");
const btnMeet = $("btnMeet");
const btnPsy = $("btnPsy");
const btnAdmin = $("btnAdmin"); // may be removed in MEra UI

// Drawer menu
const btnMenu = $("btnMenu");
const drawer = $("drawer");
const drawerOverlay = $("drawerOverlay");
const btnCloseDrawer = $("btnCloseDrawer");
const btnScene = $("btnScene");
const btnStyle = $("btnStyle");
const btnAbout = $("btnAbout");
const orbitStage = $("orbitStage");
const orbitCenterCore = $("orbitCenterCore");
const orbitActiveName = $("orbitActiveName");
const orbitActiveHint = $("orbitActiveHint");
const orbitMenuShell = $("orbitMenuShell");
const orbitTutorial = $("orbitTutorial");
const orbitTutorialDismiss = $("orbitTutorialDismiss");
const orbitSelectedEmoji = $("orbitSelectedEmoji");
const orbitSelectedTitle = $("orbitSelectedTitle");
const orbitSelectedHint = $("orbitSelectedHint");
const orbitGoBtn = $("orbitGoBtn");
const orbitPrevBtn = $("orbitPrevBtn");
const orbitNextBtn = $("orbitNextBtn");

const directoryCard = $("directoryCard");
const profileCard = $("profileCard");
const profilePage = $("profilePage");
const petCard = $("petCard");
const legacyCard = $("legacyCard");
const tabLegacyChat = $("tabLegacyChat");
const tabLegacyPolls = $("tabLegacyPolls");
const tabLegacyGossip = $("tabLegacyGossip");
const tabLegacyOnline = $("tabLegacyOnline");
const panelLegacyChat = $("panelLegacyChat");
const panelLegacyPolls = $("panelLegacyPolls");
const panelLegacyGossip = $("panelLegacyGossip");
const panelLegacyOnline = $("panelLegacyOnline");

const gossipCard = $("gossipCard");
const dmCard = $("dmCard");
const meetCard = $("meetCard");
const psyCard = $("psyCard");
const adminCard = $("adminCard");
const dashboardCard = $("dashboardCard");
const sceneCard = $("sceneCard");
const styleCard = $("styleCard");
const aboutCard = $("aboutCard");
const btnBlast = $("btnBlast");
const blastCard = $("blastCard");
const btnBackBlast = $("btnBackBlast");
const btnBlastNew = $("btnBlastNew");
const btnBlastFinish = $("btnBlastFinish");
const blastBoard = $("blastBoard");
const blastPieces = $("blastPieces");
const blastScoreEl = $("blastScore");
const blastBestEl = $("blastBest");
const blastLeaderboard = $("blastLeaderboard");
const blastMyRank = $("blastMyRank");
const blastMsg = $("blastMsg");

const btnBack = $("btnBack");
const btnBackPet = $("btnBackPet");
const btnBackLegacy = $("btnBackLegacy");
const btnBackGossip = $("btnBackGossip");
const btnBackDM = $("btnBackDM");
const btnBackMeet = $("btnBackMeet");
const btnBackPsy = $("btnBackPsy");
const btnBackAdmin = $("btnBackAdmin");
const btnBackScene = $("btnBackScene");
const btnBackStyle = $("btnBackStyle");
const btnBackAbout = $("btnBackAbout");

const tabAdminLogs = $("tabAdminLogs");
const tabAdminReports = $("tabAdminReports");
const tabAdminUsers = $("tabAdminUsers");
const panelAdminLogs = $("panelAdminLogs");
const panelAdminReports = $("panelAdminReports");
const panelAdminUsers = $("panelAdminUsers");
const adminLogsList = $("adminLogsList");
const adminReportsList = $("adminReportsList");
const adminReportStatus = $("adminReportStatus");
const btnAdminReloadReports = $("btnAdminReloadReports");
const adminUserId = $("adminUserId");
const adminMuteMin = $("adminMuteMin");
const btnAdminBan = $("btnAdminBan");
const btnAdminUnban = $("btnAdminUnban");
const btnAdminMute = $("btnAdminMute");
const btnAdminUnmute = $("btnAdminUnmute");
const adminUserMsg = $("adminUserMsg");


const statUsers = $("statUsers");
const statFarewells = $("statFarewells");
const statTop = $("statTop");

const search = $("search");
const filterSchool = $("filterSchool");
const filterYear = $("filterYear");
const userList = $("userList");
const appMsg = $("appMsg");

const profileHeader = $("profileHeader");
const viewsBadge = $("viewsBadge");
const btnViewers = $("btnViewers");

const tabProfile = $("tabProfile");
const tabInbox = $("tabInbox");
const tabFarewells = $("tabFarewells");
const tabSent = $("tabSent");

const panelProfile = $("panelProfile");
const panelInbox = $("panelInbox");
const panelFarewells = $("panelFarewells");
const panelSent = $("panelSent");

const viewersModal = $("viewersModal");
const btnCloseViewers = $("btnCloseViewers");
const viewersList = $("viewersList");

const forgotModal = $("forgotModal");
const btnForgot = $("btnForgot");
const btnCloseForgot = $("btnCloseForgot");
const btnDoReset = $("btnDoReset");
const forgotMsg = $("forgotMsg");

const legacyChat = $("legacyChat");
const legacyInput = $("legacyInput");
const btnLegacySend = $("btnLegacySend");
const legacyMsg = $("legacyMsg");

const pollQ = $("pollQ");
const pollO1 = $("pollO1");
const pollO2 = $("pollO2");
const pollO3 = $("pollO3");
const pollO4 = $("pollO4");
const btnCreatePoll = $("btnCreatePoll");
const pollMsg = $("pollMsg");
const pollList = $("pollList");

// Gossip
const gossipText = $("gossipText");
const gossipVisibility = $("gossipVisibility");
const gossipCategory = $("gossipCategory");
const gossipSort = $("gossipSort");
const gossipFilterCategory = $("gossipFilterCategory");
const btnGossipPost = $("btnGossipPost");
const gossipList = $("gossipList");
const gossipMsg = $("gossipMsg");

// DM
const dmList = $("dmList");
const dmChat = $("dmChat");
const dmWith = $("dmWith");
const dmTyping = $("dmTyping");
const dmSearch = $("dmSearch");
const btnDmClearSearch = $("btnDmClearSearch");
const dmReplyBar = $("dmReplyBar");
const dmInput = $("dmInput");
const btnDmSend = $("btnDmSend");
const btnDmVoiceRecord = $("btnDmVoiceRecord");
const btnDmAudioCall = $("btnDmAudioCall");
const btnDmMute = $("btnDmMute");
const btnDmVideoCall = $("btnDmVideoCall");
const dmPhoto = $("dmPhoto");
const dmAttachmentName = $("dmAttachmentName");
const dmRecordHint = $("dmRecordHint");
const dmVoicePreview = $("dmVoicePreview");
const dmVoicePreviewAudio = $("dmVoicePreviewAudio");
const btnDmVoiceDiscard = $("btnDmVoiceDiscard");
const dmMsg = $("dmMsg");
const btnCreateDmGroup = $("btnCreateDmGroup");
const dmGroupModal = $("dmGroupModal");
const btnCloseDmGroup = $("btnCloseDmGroup");
const dmGroupName = $("dmGroupName");
const dmGroupDesc = $("dmGroupDesc");
const dmGroupSpotify = $("dmGroupSpotify");
const dmGroupPhoto = $("dmGroupPhoto");
const dmGroupCandidates = $("dmGroupCandidates");
const dmGroupSearch = $("dmGroupSearch");
const btnDmGroupSave = $("btnDmGroupSave");
const dmGroupMsg = $("dmGroupMsg");

// Psychologist
const psyChat = $("psyChat");
const psyInput = $("psyInput");
const btnPsySend = $("btnPsySend");
const psyMsg = $("psyMsg");

// Follows modal
const followsModal = $("followsModal");
const followsTitle = $("followsTitle");
const followsList = $("followsList");
const btnCloseFollows = $("btnCloseFollows");
const photoModal = $("photoModal");
const photoModalBody = $("photoModalBody");
const btnClosePhotoModal = $("btnClosePhotoModal");
const meetQuestionModal = $("meetQuestionModal");
const btnCloseMeetQuestion = $("btnCloseMeetQuestion");
const btnSendMeetQuestion = $("btnSendMeetQuestion");
const meetQuestionText = $("meetQuestionText");
const meetQuestionMsg = $("meetQuestionMsg");
const meetQuestionMeta = $("meetQuestionMeta");
const meetReviewModal = $("meetReviewModal");
const btnCloseMeetReview = $("btnCloseMeetReview");
const btnSendMeetReview = $("btnSendMeetReview");
const meetReviewText = $("meetReviewText");
const meetReviewMsg = $("meetReviewMsg");
const meetReviewMeta = $("meetReviewMeta");
const meetReviewStars = $("meetReviewStars");


let me = null;
let selectedUser = null;
let homeEntrancePending = true;
let currentView = "dashboard";
let orbitRotation = 0;
let orbitDragging = false;
let orbitPointerId = null;
let orbitDragStartX = 0;
let orbitRotationStart = 0;
let orbitDragStartAngle = 0;
let orbitVelocity = 0;
let orbitLastMoveTime = 0;
let orbitLastMoveRotation = 0;
let orbitMomentumFrame = null;
let orbitSelectedId = "";
let orbitDirectNavigateId = null;
const ORBIT_TUTORIAL_KEY = "mera_orbit_tutorial_seen_v3";
 // dashboard | directory | profile | legacy | dm | meet | nova | scene | style | blast | about
let currentPhotoPosts = [];
let currentProfileMode = "other"; // my | other
let activeTab = "profile"; // profile | inbox | farewells | sent
let activeMeetCategory = "coffee";
let activeMeetMode = "open";
let editingMeetupId = null;
let confirmedMeetDate = "";
let pendingMeetQuestionId = 0;
let pendingMeetQuestionTitle = "";
let pendingMeetReviewId = 0;
let pendingMeetReviewTitle = "";
let pendingMeetReviewStars = 0;
let dashboardCache = null;
let sceneSummaryCache = null;
let styleFeedCache = [];
let styleSummaryCache = {};
let styleComposeMode = 'outfit';
let styleFeedMode = 'all';
let styleStoreFilter = 'all';
let styleDashboardFeed = [];
let orbitNavigateTimer = null;
let styleDraftItems = [];

let sceneFeedCache = [];
let lang = localStorage.getItem(LANG_KEY) || "tr";
let navStack = [];
let suppressNavPush = false;
document.documentElement.lang = lang;
const I18N = {
  tr:{logout:"Çıkış",students:"Öğrenciler",myProfile:"Profilim",pet:"Avatarlar",legacy:"Eski Toprak",dm:"DM",meet:"MEra Orbit",psych:"",about:"MEra – Hakkında",welcome:"Welcome to MEra.",authTitle:"MEra • Giriş / Kayıt",authIntro:"Giriş yapınca hesabın kalıcı olur. Çıkış yapmadıkça tekrar giriş istemez.",login:"Giriş",register:"Kayıt",email:"E-posta",password:"Şifre",loginBtn:"Giriş Yap",forgot:"Şifremi Unuttum",fullName:"Ad Soyad",school:"Okul",gradYear:"Mezuniyet Yılı (1995 - bu yıl)",registerBtn:"Kayıt Ol",search:"İsim veya e-posta ara...",schoolFilter:"Okul filtresi",yearAll:"Mezuniyet (hepsi)",back:"Geri",chats:"Sohbetler",chooseChat:"Sohbet seç",searchDm:"DM içinde ara...",clear:"Temizle",writeMsg:"Mesaj yaz...",send:"Gönder",photoRequired:"Foto seç.",uploaded:"✅ Yüklendi.",saved:"✅ Kaydedildi.",sentOk:"✅ Gönderildi.",writeMessageErr:"Mesaj yaz.",profileInfo:"Profil Bilgileri",profilePhoto:"Profil Fotoğrafı",uploadPhoto:"Fotoğrafı Yükle",cancel:"Vazgeç",biography:"Biyografi",instagram:"Instagram",phone:"Telefon",profileMusic:"Profil Müziği",link:"Linki aç",platform:"Platform",save:"Kaydet",sendFarewell:"✍️ Veda Mesajı Gönder (+ İstersen şarkı linki)",farewellPlaceholder:"Veda mesajın...",songPlatform:"Şarkı platformu (opsiyonel)",songLink:"Şarkı linki (opsiyonel)",loading:"Yükleniyor...",emptyList:"Liste boş.",followers:"Takipçiler",following:"Takip",follow:"Takip İsteği Gönder",unfollow:"Takibi Bırak",message:"Mesajlaş",mutual:"✅ Karşılıklı takip",mutualReq:"🔒 DM için karşılıklı takip",schoolLabel:"Okul",gradLabel:"Mezuniyet",requestSent:"⏳ Takip isteği gönderildi",requestReceived:"Bu kişi sana istek gönderdi",accept:"Kabul Et",reject:"Reddet",photos:"Fotoğraflar",sharePhoto:"Fotoğraf paylaş",caption:"Açıklama",noPhotos:"Henüz fotoğraf yok.",like:"Beğen",comment:"Yorum",comments:"Yorumlar",writeComment:"Yorum yaz...",deletePhoto:"Sil",deleteComment:"Yorumu sil",openDmPrompt:"DM açıldı. Mesajını aşağıdan yazabilirsin.",viewComments:"Yorumları gör",photoLiked:"Beğenildi",contactInfo:"İletişim Bilgileri",quickActions:"Hızlı İşlemler",editProfile:"Profilini Düzenle",shareNewPhoto:"Yeni Fotoğraf Paylaş",accountDetails:"Hesap Detayları",socialLinks:"Sosyal & İletişim",yearLockHint:"Mezuniyet yılı yalnızca 1 kere ayarlanabilir.",photoTip:"Profil fotoğrafını güncelle veya temizle.",postTip:"İstediğin kadar fotoğraf paylaşabilirsin.", online:"Aktif", lastSeen:"Son görülme", typingNow:"yazıyor…", noDmYet:"Henüz konuşma yok. Sol tarafta takipleştiğin kişiler görünüyor; birine basıp ilk mesajı gönderebilirsin.", noMessagesWith:"Bu kişiyle henüz konuşma yok. Aşağıdan ilk mesajı yazınca sohbet başlayacak.", selectChatFirst:"Önce sohbet seç.", startChat:"Mesajlaşmaya başla", attachment:"Dosya yükle", dmServerIssue:"DM alanında bir sunucu sorunu oluştu. Şimdi daha güvenli hata yönetimiyle tekrar dene.", languages:"Dil", confirmPassword:"Şifre Tekrar", showPassword:"Göster", hidePassword:"Gizle", authEmailPlaceholder:"ornek@outlook.com", authSchoolPlaceholder:"Okul adı", passwordStrengthWaiting:"Kontrol bekleniyor"},
  en:{logout:"Logout",students:"Students",myProfile:"My Profile",pet:"Avatars",legacy:"Legacy",dm:"DM",meet:"MEra Orbit",psych:"",about:"About MEra",welcome:"Welcome to MEra.",authTitle:"MEra • Login / Register",authIntro:"Once you log in, your account stays signed in until you log out.",login:"Login",register:"Register",email:"Email",password:"Password",loginBtn:"Login",forgot:"Forgot Password",fullName:"Full Name",school:"School",gradYear:"Graduation Year (1995 - this year)",registerBtn:"Register",search:"Search by name or email...",schoolFilter:"School filter",yearAll:"Graduation (all)",back:"Back",chats:"Chats",chooseChat:"Select a chat",searchDm:"Search in DM...",clear:"Clear",writeMsg:"Write a message...",send:"Send",photoRequired:"Select a photo.",uploaded:"✅ Uploaded.",saved:"✅ Saved.",sentOk:"✅ Sent.",writeMessageErr:"Write a message.",profileInfo:"Profile Information",profilePhoto:"Profile Photo",uploadPhoto:"Upload Photo",cancel:"Cancel",biography:"Biography",instagram:"Instagram",phone:"Phone",profileMusic:"Profile Music",link:"Open link",platform:"Platform",save:"Save",sendFarewell:"✍️ Send a Farewell Message (+ optional song link)",farewellPlaceholder:"Your farewell message...",songPlatform:"Song platform (optional)",songLink:"Song link (optional)",loading:"Loading...",emptyList:"List is empty.",followers:"Followers",following:"Following",follow:"Send Follow Request",unfollow:"Unfollow",message:"Message",mutual:"✅ Mutual follow",mutualReq:"🔒 Mutual follow required for DM",schoolLabel:"School",gradLabel:"Graduation",requestSent:"⏳ Follow request sent",requestReceived:"This person sent you a request",accept:"Accept",reject:"Reject",photos:"Photos",sharePhoto:"Share photo",caption:"Caption",noPhotos:"No photos yet.",like:"Like",comment:"Comment",comments:"Comments",writeComment:"Write a comment...",deletePhoto:"Delete",deleteComment:"Delete comment",openDmPrompt:"DM opened. You can send a message below.",viewComments:"View comments",photoLiked:"Liked",contactInfo:"Contact Information",quickActions:"Quick Actions",editProfile:"Edit Profile",shareNewPhoto:"Share New Photo",accountDetails:"Account Details",socialLinks:"Social & Contact",yearLockHint:"Graduation year can only be set once.",photoTip:"Update or clear your profile photo.",postTip:"You can share as many photos as you want.", online:"Online", lastSeen:"Last seen", typingNow:"typing…", noDmYet:"No conversation yet. Mutual follows appear on the left; tap one to start the first message.", noMessagesWith:"There is no conversation with this person yet. Send the first message below to start.", selectChatFirst:"Select a chat first.", startChat:"Start chatting", attachment:"Attach file", dmServerIssue:"There was a server issue in DM. Try again with the improved error handling.", languages:"Language", confirmPassword:"Confirm Password", showPassword:"Show", hidePassword:"Hide", authEmailPlaceholder:"name@outlook.com", authSchoolPlaceholder:"School name", passwordStrengthWaiting:"Waiting for check"}
};

Object.assign(I18N.tr, {
  authEyebrow:"WELCOME TO MERA",
  authKicker:"YENİ NESİL MEZUNİYET AĞI",
  authLine1:"Bir dönem",
  authLine2:"biter.",
  authLine3:"Bir çağ başlar.",
  authHeroLead:"MEra’da vedalar, anılar ve bağlar sadece saklanmaz. Güçlenir.",
  authChipIdentity:"🐺 Güçlü kimlik",
  authChipModern:"✨ Modern deneyim",
  authChipNetwork:"🎓 Mezun ağı",
  authChipSecurity:"🛡️ Güvenli başlangıç",
  authStatCardTitle:"İlk izlenim",
  authStatCardBody:"Sade değil, sinematik bir giriş.",
  authStatCardHint:"Hareketli ışık katmanları ve güçlü tipografiyle açılış anı daha etkileyici.",
  authMetric1Value:"24/7",
  authMetric1Label:"kalıcı oturum",
  authMetric2Value:"Any",
  authMetric2Label:"geçerli e-posta alan adı",
  authMetric3Value:"+10",
  authMetric3Label:"güçlü şifre standardı",
  orbitHeaderMeta:"Dokun • seç • git",
  orbitSelectedLabel:"SEÇİLİ ROTA",
  orbitRouteEyebrow:"AKTİF ROTA",
  orbitGo:"Git",
  orbitQuickDashboard:"Ana akış",
  orbitQuickStudents:"Öğrenciler",
  orbitQuickMessages:"Mesajlar",
  orbitQuickManifesto:"Manifesto",
  orbitTutorialEyebrow:"İLK KULLANIM",
  orbitTutorialTitle:"Kartlı Orbit nasıl kullanılır?",
  orbitTutorialText:"Bir karta dokun ya da tıkla; kart öne gelir ve seçilir. Ortadaki Git ile açabilir, istersen sağ-sol oklarla diğer alanlara geçebilirsin.",
  orbitTutorialDismiss:"Anladım",
  orbitCoreDefaultHint:"Kartı seç, sonra Git ile aç.",
  orbitHintDashboard:"Ana akış, özet kartlar ve hızlı geçişler burada.",
  orbitHintDirectory:"Kişileri filtreleyip profillere hızlıca geçebilirsin.",
  orbitHintProfile:"Profil düzeni, fotoğraflar ve bağlantılar tek alanda.",
  orbitHintPet:"Avatarını büyüt, besle ve ortak avatarlarını yönet.",
  orbitHintLegacy:"Topluluk konuşmaları ve gündem akışı burada dönüyor.",
  orbitHintGossip:"En sıcak konuşmalar ve trend akış burada.",
  orbitHintDm:"Özel mesajlara anında geçiş yap.",
  orbitHintMeet:"Bağlantı ve etkileşim alanı için merkez rota.",
  orbitHintNova:"Daha enerjik akış ve keşif deneyimi burada.",
  orbitHintScene:"Sahne, içerik ve görsel paylaşım alanı.",
  orbitHintStyle:"Kombinler, indirimler ve stil akışı burada.",
  orbitHintAbout:"Manifesto, çağ ve marka hissi burada anlatılıyor.",
  orbitDescDashboard:"Günün özeti",
  orbitDescDirectory:"Kişileri keşfet",
  orbitDescProfile:"Kendi alanın",
  orbitDescPet:"Avatar bakımı",
  orbitDescLegacy:"Topluluk akışı",
  orbitDescGossip:"Trend konuşmalar",
  orbitDescDm:"Mesajlara geç",
  orbitDescMeet:"Buluş ve bağlan",
  orbitDescNova:"Yeni odalar",
  orbitDescScene:"Sahne akışı",
  orbitDescStyle:"Kombin ve deal",
  orbitDescAbout:"Manifestoyu aç",
  authAnyDomainNote:"Her geçerli e-posta alan adı desteklenir.",
  authLoginHint:"Gmail şart değil; geçerli herhangi bir e-posta ile giriş yapabilirsin.",
  authEmailAnyHint:"@gmail zorunlu değil. Outlook, Hotmail, okul veya kurumsal adresler kullanılabilir.",
  authSchoolHint:"Alan adı artık daha esnek. Lise yazmasa da okul adı kabul edilir.",
  authSecurityEyebrow:"Şifre Güvenliği",
  authSecurityTitle:"Kolay şifreler artık engelleniyor",
  passwordRuleLength:"En az 10 karakter",
  passwordRuleCase:"Büyük + küçük harf",
  passwordRuleNumber:"En az 1 rakam",
  passwordRuleSpecial:"En az 1 özel karakter",
  passwordRuleMatch:"İki şifre aynı olmalı",
  passwordRuleCommon:"Çok kolay veya tahmin edilir olmamalı",
  forgotPasswordHint:"Yeni şifre de güçlü kurallara uymalı.",
  gradYearExample:"örn: 2026",
  classLabel:"Sınıf / Şube",
  classPlaceholder:"Örn: 12A",
  sameClass:"Aynı sınıftasınız",
  sameSchool:"Aynı okuldan",
  directoryTitle:"Öğrenciler",
  totalStudents:"Toplam Öğrenci",
  totalFarewells:"Toplam Veda",
  topMessaged:"En Çok Mesaj Alan",
  selectedProfileTitle:"Seçili Profil",
  selectedProfileHint:"Bir öğrenci seçince profil burada açılır.",
  whoViewed:"Kim baktı?",
  viewersPrivate:"🔒 Sadece sen görürsün",
  profileTab:"Profil",
  inboxTab:"Gelen Vedalar",
  farewellsTab:"Vedalar",
  sentTab:"Gönderdiğim",
  backArrow:"← Geri",
  backStudents:"← Öğrenciler",
  legacyTitle:"Eski Toprak",
  legacyDesc:"Mezunlardan yardım ve tavsiye alabileceğin sohbet + anket alanı.",
  chatLabel:"Sohbet",
  legacyInput:"Mesaj yaz... (Enter)",
  openPoll:"Anket Aç",
  pollQuestion:"Anket sorusu",
  option1:"Seçenek 1",
  option2:"Seçenek 2",
  option3:"Seçenek 3 (opsiyonel)",
  option4:"Seçenek 4 (opsiyonel)",
  publishPoll:"Anketi Yayınla",
  pollsTitle:"Anketler",
  gossipTitle:"Dedikodu",
  gossipDesc:"Öğretmenler/okullar hakkında paylaş. \"Sadece Benim Okulum\" seçersen, sadece aynı okuldan olanlar görür.",
  writeSomething:"Bir şeyler yaz...",
  globalOpt:"🌍 Genel",
  schoolOnlyOpt:"🏫 Sadece Benim Okulum",
  share:"Paylaş",
  aboutTitle:"MEra – Hakkında",
  aboutLead:"Bir uygulama değil. Bir çağdır.",
  about1:"Her mezun bir sürünün parçasıdır.",
  about2:"Aynı dönemi paylaşanlar, aynı geleceğe yürür.",
  about3:"Anılar burada saklanmaz.",
  about4:"Burada güçlenir.",
  about5:"Bağlantılar burada kurulmaz.",
  about6:"Burada bir harekete dönüşür.",
  about7:"Bir dönem biter.",
  about8:"Bir çağ başlar.",
  about9:"Bu senin dönemin.",
  about10:"Bu senin çağın.",
  meetTitle:"MEra Buluş",
  meetDesc:"Aynı şehirde kahve planı yap ya da halı saha için eksik oyuncuyu bul.",
  meetCoffee:"☕ Kahve",
  meetPitch:"⚽ Halı Saha",
  meetCreateTitle:"Yeni ilan oluştur",
  meetListingTitle:"Başlık",
  meetListingTitlePh:"Örn: Kadıköy'de akşam kahvesi",
  meetCity:"Şehir",
  meetCityPh:"Örn: İstanbul",
  meetDateLabel:"Tarih",
  meetNeedCount:"Gereken kişi",
  meetNeedCountPh:"Kaç kişi eksik?",
  meetNote:"Not",
  meetNotePh:"Saat, semt veya detay yazabilirsin",
  meetPublish:"İlanı Yayınla",
  meetOpenListings:"Açık ilanlar",
  meetFilterCity:"Şehre göre filtrele",
  refresh:"Yenile",
  meetEmpty:"Şu an açık ilan yok. İlk ilanı sen açabilirsin.",
  meetDelete:"İlanı Sil",
  meetOpenDm:"Mesajlaş",
  meetupCreated:"✅ İlan yayınlandı.",
  dmTitle:"Özel Mesajlar (DM)",
  dmSubtitle:"Takipleştiğin kişiler, aktif durum ve daha düzenli sohbet görünümü",
  viewersTitle:"Profilime Bakanlar",
  photoModalTitle:"Fotoğraf",
  forgotTitle:"Şifre Sıfırla",
  forgotDesc:"Bu demo projede e-posta doğrulama yok. Aynı e-posta için yeni şifre belirleyebilirsin.",
  newPassword:"Yeni şifre",
  changePassword:"Şifreyi Değiştir",
  close:"Kapat"
});
Object.assign(I18N.en, {
  authEyebrow:"WELCOME TO MERA",
  authKicker:"NEXT-GEN GRADUATION NETWORK",
  authLine1:"One era",
  authLine2:"ends.",
  authLine3:"A new age begins.",
  authHeroLead:"On MEra, farewells, memories, and connections are not just stored. They grow stronger.",
  authChipIdentity:"🐺 Strong identity",
  authChipModern:"✨ Modern experience",
  authChipNetwork:"🎓 Alumni network",
  authChipSecurity:"🛡️ Safer start",
  authStatCardTitle:"First impression",
  authStatCardBody:"Not plain — cinematic.",
  authStatCardHint:"Animated light layers and stronger typography make the first screen feel premium.",
  authMetric1Value:"24/7",
  authMetric1Label:"sticky session",
  authMetric2Value:"Any",
  authMetric2Label:"valid email domain",
  authMetric3Value:"+10",
  authMetric3Label:"strong password standard",
  authAnyDomainNote:"Any valid email domain is supported.",
  authLoginHint:"Gmail is not required. You can sign in with any valid email address.",
  authEmailAnyHint:"@gmail is not required. Outlook, Hotmail, school, and corporate addresses are accepted.",
  authSchoolHint:"School names are now more flexible. They can be accepted even without words like high school or university.",
  authSecurityEyebrow:"Password Security",
  authSecurityTitle:"Easy passwords are now blocked",
  passwordRuleLength:"At least 10 characters",
  passwordRuleCase:"Uppercase + lowercase",
  passwordRuleNumber:"At least 1 number",
  passwordRuleSpecial:"At least 1 special character",
  passwordRuleMatch:"Both passwords must match",
  passwordRuleCommon:"Must not be too easy or predictable",
  forgotPasswordHint:"The new password must also follow the strong rules.",
  gradYearExample:"e.g. 2026",
  classLabel:"Class / Section",
  classPlaceholder:"e.g. 12A",
  sameClass:"You are in the same class",
  sameSchool:"Same school",
  directoryTitle:"Students",
  totalStudents:"Total Students",
  totalFarewells:"Total Farewells",
  topMessaged:"Most Messaged",
  selectedProfileTitle:"Selected Profile",
  selectedProfileHint:"When you select a student, the profile opens here.",
  whoViewed:"Who viewed?",
  viewersPrivate:"🔒 Only you can see this",
  profileTab:"Profile",
  inboxTab:"Incoming Farewells",
  farewellsTab:"Farewells",
  sentTab:"Sent",
  backArrow:"← Back",
  backStudents:"← Students",
  legacyTitle:"Legacy",
  legacyDesc:"A chat + poll area where you can get advice and help from graduates.",
  chatLabel:"Chat",
  legacyInput:"Write a message... (Enter)",
  openPoll:"Create Poll",
  pollQuestion:"Poll question",
  option1:"Option 1",
  option2:"Option 2",
  option3:"Option 3 (optional)",
  option4:"Option 4 (optional)",
  publishPoll:"Publish Poll",
  pollsTitle:"Polls",
  gossipTitle:"Gossip",
  gossipDesc:"Share thoughts about teachers or schools. If you choose \"My School Only\", only people from the same school can see it.",
  writeSomething:"Write something...",
  globalOpt:"🌍 Global",
  schoolOnlyOpt:"🏫 My School Only",
  share:"Share",
  aboutTitle:"About MEra",
  aboutLead:"Not an app. An era.",
  about1:"Every graduate is part of a pack.",
  about2:"Those who shared the same year walk toward the same future.",
  about3:"Memories are not just stored here.",
  about4:"They become stronger here.",
  about5:"Connections are not just made here.",
  about6:"They turn into a movement here.",
  about7:"One era ends.",
  about8:"A new age begins.",
  about9:"This is your era.",
  about10:"This is your age.",
  meetTitle:"MEra Meet",
  meetDesc:"Plan a coffee meetup in the same city or find the missing players for a football match.",
  meetCoffee:"☕ Coffee",
  meetPitch:"⚽ Football",
  meetCreateTitle:"Create a new listing",
  meetListingTitle:"Title",
  meetListingTitlePh:"e.g. Evening coffee in Kadıköy",
  meetCity:"City",
  meetCityPh:"e.g. Istanbul",
  meetDateLabel:"Date",
  meetNeedCount:"Players needed",
  meetNeedCountPh:"How many are missing?",
  meetNote:"Note",
  meetNotePh:"You can add time, district, or extra detail",
  meetPublish:"Publish Listing",
  meetOpenListings:"Open listings",
  meetFilterCity:"Filter by city",
  refresh:"Refresh",
  meetEmpty:"There are no open listings right now. You can create the first one.",
  meetDelete:"Delete Listing",
  meetOpenDm:"Message",
  meetupCreated:"✅ Listing published.",
  dmTitle:"Direct Messages (DM)",
  dmSubtitle:"People you follow, active status, and a cleaner conversation layout",
  viewersTitle:"Profile Viewers",
  photoModalTitle:"Photo",
  forgotTitle:"Reset Password",
  forgotDesc:"This demo project has no email verification. You can set a new password for the same email.",
  newPassword:"New password",
  changePassword:"Change Password",
  close:"Close"

});


Object.assign(I18N.tr, {
  meetTitle:"MEra Orbit",
  meetDesc:"Kahve planı kur, halı saha ekibini tamamla ve ilgini çeken ilanları kaydet.",
  meetCoffee:"☕ Kahve",
  meetPitch:"⚽ Halı Saha",
  meetCreateTitle:"Yeni ilan oluştur",
  meetListingTitle:"Başlık",
  meetListingTitlePh:"Örn: Kadıköy kahve planı",
  meetProvince:"İl",
  meetProvincePh:"Örn: İstanbul",
  meetDistrict:"İlçe / Semt",
  meetDistrictPh:"Örn: Kadıköy",
  meetDateLabel:"Tarih",
  meetGender:"Katılımcı cinsiyeti",
  meetGenderAny:"Farketmez",
  meetGenderFemale:"Kadın",
  meetGenderMale:"Erkek",
  meetGenderMixed:"Karma",
  meetAge:"Ortalama yaş",
  meetAgePh:"Örn: 20",
  meetNeedCount:"Gereken kişi",
  meetNeedCountPh:"Kaç kişi eksik?",
  meetNote:"Not",
  meetNotePh:"Saat, semt veya detay yazabilirsin",
  meetPublish:"İlanı Yayınla",
  meetOpenListings:"İlanlar",
  meetFilterProvince:"İle göre filtrele",
  meetEmpty:"Şu an açık ilan yok. İlk ilanı sen açabilirsin.",
  meetSavedEmpty:"Henüz kaydettiğin ilan yok.",
  meetDelete:"İlanı Sil",
  meetOpenDm:"Mesajlaş",
  meetupCreated:"✅ İlan yayınlandı.",
  meetOpen:"Açık İlanlar",
  meetSaved:"Kaydettiklerim",
  meetSave:"Kaydet",
  meetUnsave:"Kaydı Kaldır",
  meetSavedOk:"✅ İlan kaydedildi.",
  meetUnsavedOk:"✅ Kayıt kaldırıldı.",
  meetGenderLabel:"Cinsiyet",
  meetAgeLabel:"Yaş",
  meetMissingLabel:"Eksik kişi",
  meetPhoto:"İlan fotoğrafı",
  meetPhotoHint:"İstersen profil fotoğrafından farklı bir fotoğraf ekleyebilirsin.",
  meetToday:"Bugün",
  meetTomorrow:"Yarın",
  meetThisWeek:"Bu hafta",
  meetListingOwner:"İlan sahibi",
  meetWhenLabel:"Zaman",
  meetLocationLabel:"Konum",
  meetOpenSavedOne:"Kaydedilenleri aç",
  meetCardCoffee:"Kahve planı",
  meetCardPitch:"Halı saha ekibi",
  meetJoin:"Katıl",
  meetJoinPending:"İstek Gönderildi",
  meetJoinAccepted:"Kabul Edildi",
  meetJoinRejected:"Tekrar İstek",
  meetCancelRequest:"İsteği Geri Çek",
  meetRequestsTitle:"İstek Kutusu",
  meetRequestsDesc:"İlanlarına gelmek isteyenleri buradan seçebilirsin.",
  meetAcceptedTitle:"Katılanlar",
  meetAcceptedDesc:"Onayladığın kişiler burada görünür.",
  meetNoRequests:"Şu an bekleyen istek yok.",
  meetNoAccepted:"Henüz onayladığın kimse yok.",
  meetRequestAccept:"Seç",
  meetRequestReject:"Reddet",
  meetRequestSentOk:"✅ Katılma isteği gönderildi.",
  meetRequestCanceledOk:"✅ İstek geri çekildi.",
  meetRequestAcceptedOk:"✅ İstek kabul edildi.",
  meetRequestRejectedOk:"✅ İstek reddedildi.",
  meetApplicants:"Başvuranlar",
  meetAttendeesLabel:"Gelenler",
  meetStatusClosed:"Kapanan",
  meetStatusFull:"Dolu",
  meetStatusOpen:"Açık",
  meetPendingCount:"Bekleyen",
  meetAcceptedCount:"Gelen",
  meetRequestNotePrompt:"İstersen kısa bir not yaz",
  meetRequestPanelHint:"İlan sahibi olarak burada seçim yapabilirsin.",
  meetConfirmDate:"Tarihi Onayla",
  meetDateNotConfirmed:"Tarih seçildiğinde burada görünecek.",
  meetDatePending:"Tarih seçildi, şimdi onayla.",
  meetDateConfirmed:"Onaylanan tarih",
  meetNeedDateConfirm:"Tarihi seçtikten sonra onayla.",
  meetDuration:"İlan süresi",
  meetDurationDays:"Gün",
  meetDurationHours:"Saat",
  meetDurationHint:"İlan bu sürenin sonunda otomatik kapanır.",
  meetDurationError:"İlan süresi 1 ile 30 arasında olmalı.",
  meetEdit:"İlanı Düzenle",
  meetUpdate:"Değişiklikleri Kaydet",
  meetUpdated:"✅ İlan güncellendi.",
  meetEditMode:"Düzenleme modu açık.",
  meetAskOwner:"İlan Sahibine Soru Sor",
  meetQuestionPlaceholder:"Kısa bir soru yaz",
  meetQuestionEmpty:"Önce sorunu yaz.",
  meetQuestionSent:"✅ Soru gönderildi.",
  meetQuestionsTitle:"Sorular",
  meetQuestionsDesc:"İlan sahiplerine gelen sorular burada görünür.",
  meetNoQuestions:"Henüz soru yok.",
  meetAnswer:"Cevapla",
  meetAnswerPrompt:"Kısa bir cevap yaz",
  meetAnswerSaved:"✅ Cevap kaydedildi.",
  meetReviewTitle:"İlan Sahibine Puan Ver",
  meetReviewPlaceholder:"Nasıl geçtiğini yaz",
  meetReviewAction:"Puanla",
  meetReviewNeedStar:"Önce yıldız seç.",
  meetReviewSaved:"✅ Puanın kaydedildi.",
  questions:"soru",
  left:"kaldı"
});
Object.assign(I18N.en, {
  meetTitle:"MEra Orbit",
  meetDesc:"Set up a coffee plan, complete your football team, and save the listings you want to revisit.",
  meetCoffee:"☕ Coffee",
  meetPitch:"⚽ Football",
  meetCreateTitle:"Create a new listing",
  meetListingTitle:"Title",
  meetListingTitlePh:"e.g. Kadıköy coffee plan",
  meetProvince:"Province",
  meetProvincePh:"e.g. Istanbul",
  meetDistrict:"District / Area",
  meetDistrictPh:"e.g. Kadıköy",
  meetDateLabel:"Date",
  meetGender:"Participant gender",
  meetGenderAny:"Any",
  meetGenderFemale:"Women",
  meetGenderMale:"Men",
  meetGenderMixed:"Mixed",
  meetAge:"Average age",
  meetAgePh:"e.g. 20",
  meetNeedCount:"Players needed",
  meetNeedCountPh:"How many are missing?",
  meetNote:"Note",
  meetNotePh:"You can add time, district, or extra detail",
  meetPublish:"Publish Listing",
  meetOpenListings:"Listings",
  meetFilterProvince:"Filter by province",
  meetEmpty:"There are no open listings right now. You can create the first one.",
  meetSavedEmpty:"You have not saved any listings yet.",
  meetDelete:"Delete Listing",
  meetOpenDm:"Message",
  meetupCreated:"✅ Listing published.",
  meetOpen:"Open Listings",
  meetSaved:"Saved",
  meetSave:"Save",
  meetUnsave:"Remove Save",
  meetSavedOk:"✅ Listing saved.",
  meetUnsavedOk:"✅ Save removed.",
  meetGenderLabel:"Gender",
  meetAgeLabel:"Age",
  meetMissingLabel:"Missing players",
  meetPhoto:"Listing photo",
  meetPhotoHint:"You can add a different photo instead of your profile photo.",
  meetToday:"Today",
  meetTomorrow:"Tomorrow",
  meetThisWeek:"This week",
  meetListingOwner:"Host",
  meetWhenLabel:"When",
  meetLocationLabel:"Location",
  meetOpenSavedOne:"Open saved",
  meetCardCoffee:"Coffee plan",
  meetCardPitch:"Football squad",
  meetJoin:"Join",
  meetJoinPending:"Request Sent",
  meetJoinAccepted:"Accepted",
  meetJoinRejected:"Request Again",
  meetCancelRequest:"Withdraw Request",
  meetRequestsTitle:"Request Box",
  meetRequestsDesc:"Choose who can join your listings from here.",
  meetAcceptedTitle:"Attendees",
  meetAcceptedDesc:"People you approved appear here.",
  meetNoRequests:"There are no pending requests right now.",
  meetNoAccepted:"You have not approved anyone yet.",
  meetRequestAccept:"Approve",
  meetRequestReject:"Reject",
  meetRequestSentOk:"✅ Join request sent.",
  meetRequestCanceledOk:"✅ Request withdrawn.",
  meetRequestAcceptedOk:"✅ Request approved.",
  meetRequestRejectedOk:"✅ Request rejected.",
  meetApplicants:"Applicants",
  meetAttendeesLabel:"Attendees",
  meetStatusClosed:"Closed",
  meetStatusFull:"Full",
  meetStatusOpen:"Open",
  meetPendingCount:"Pending",
  meetAcceptedCount:"Joined",
  meetRequestNotePrompt:"Add a short note if you want",
  meetRequestPanelHint:"As the host, you can choose people here.",
  meetConfirmDate:"Confirm Date",
  meetDateNotConfirmed:"The selected date will appear here.",
  meetDatePending:"Date selected, now confirm it.",
  meetDateConfirmed:"Confirmed date",
  meetNeedDateConfirm:"Confirm the date after selecting it.",
  meetDuration:"Listing duration",
  meetDurationDays:"Days",
  meetDurationHours:"Hours",
  meetDurationHint:"The listing closes automatically after this period.",
  meetDurationError:"Listing duration must be between 1 and 30.",
  meetEdit:"Edit Listing",
  meetUpdate:"Save Changes",
  meetUpdated:"✅ Listing updated.",
  meetEditMode:"Edit mode is active.",
  meetAskOwner:"Ask the Host",
  meetQuestionPlaceholder:"Write a short question",
  meetQuestionEmpty:"Write your question first.",
  meetQuestionSent:"✅ Question sent.",
  meetQuestionsTitle:"Questions",
  meetQuestionsDesc:"Questions sent to your listings appear here.",
  meetNoQuestions:"No questions yet.",
  meetAnswer:"Answer",
  meetAnswerPrompt:"Write a short answer",
  meetAnswerSaved:"✅ Answer saved.",
  meetReviewTitle:"Rate the Host",
  meetReviewPlaceholder:"Write how it went",
  meetReviewAction:"Rate",
  meetReviewNeedStar:"Pick a star first.",
  meetReviewSaved:"✅ Your rating was saved.",
  questions:"questions",
  left:"left"
});

Object.assign(I18N.tr, {
  createGroup:"+ Grup",
  groupCreateTitle:"Yeni Grup DM",
  groupCreateHint:"En az 3 kişilik grup için senden başka en az 2 kişi seç.",
  groupName:"Grup adı",
  groupLink:"Spotify / link (opsiyonel)",
  groupDesc:"Kısa açıklama (opsiyonel)",
  groupPhoto:"Grup fotoğrafı seç",
  groupMembers:"Üyeler",
  groupSearch:"Kişi ara...",
  groupCreateBtn:"Grubu Oluştur",
  groupCreated:"✅ Grup oluşturuldu.",
  groupNeedMembers:"Senden başka en az 2 kişi seçmelisin.",
  groupNoCandidates:"Henüz ekleyebileceğin karşılıklı takip yok.",
  groupStart:"Grup konuşmasını başlat",
  groupTag:"GRUP",
  groupCount:"üye",
  groupTypingNow:"yazıyor…"
});
Object.assign(I18N.en, {
  createGroup:"+ Group",
  groupCreateTitle:"New Group DM",
  groupCreateHint:"Choose at least 2 other people so the group has 3 members minimum.",
  groupName:"Group name",
  groupLink:"Spotify / link (optional)",
  groupDesc:"Short description (optional)",
  groupPhoto:"Choose group photo",
  groupMembers:"Members",
  groupSearch:"Search people...",
  groupCreateBtn:"Create Group",
  groupCreated:"✅ Group created.",
  groupNeedMembers:"Choose at least 2 other people.",
  groupNoCandidates:"There are no mutual followers you can add yet.",
  groupStart:"Start the group chat",
  groupTag:"GROUP",
  groupCount:"members",
  groupTypingNow:"typing…"
});


Object.assign(I18N.tr, {
  novaTitle:"MEra Nova",
  novaDesc:"Zaman kapsülü, dönem haritası, odalar, anı duvarı ve sınıf yıllığı tek yerde.",
  novaTabCapsule:"⏳ Zaman Kapsülü",
  novaTabMap:"🗺️ Dönem Haritası",
  novaTabRooms:"🫂 Odalar",
  novaTabWall:"🧠 Anı Duvarı",
  novaTabYearbook:"📘 Yıllık",
  schoolNamePh:"Okul adı",
  yearbookTitle:"Sınıf Yıllığı",
  yearbookLoad:"Yıllığı Getir",
  yearbookFriendsMatches:"Dönem arkadaşları ve eşleşmeler",
  yearbookSameClass:"Aynı Sınıfındakiler",
  yearbookSameSchool:"Aynı Okuldan Diğerleri",
  yearbookMatches:"Ortak anı eşleşmeleri",
  yearbookPlaylistTitle:"Dönem Playlist’i",
  yearbookAddSong:"Şarkı Bırak",
  yearbookSongNotePh:"Bu şarkı o dönemi neden anlatıyor?",
  yearbookQuoteTitle:"Dönem / Öğretmen Sözü",
  yearbookQuoteType:"Söz türü",
  yearbookQuotePeriod:"Dönem sözü",
  yearbookQuoteTeacher:"Öğretmen sözü",
  yearbookQuoteBody:"Söz",
  yearbookQuotePh:"Kısa ama hatırlanacak bir söz bırak",
  yearbookQuoteAdd:"Sözü Bırak",
  yearbookAwards:"Öne Çıkanlar",
  yearbookTopTalker:"Sınıfın en çok konuşanı",
  yearbookTopFarewell:"En çok veda alan",
  yearbookTopPhotos:"En çok fotoğraf paylaşan",
  yearbookThemeSong:"Bu dönemin şarkısı",
  yearbookQuotesList:"Sözler",
  cityPresenceTitle:"Bugün Kim Nerede?",
  songLinkLabel:"Şarkı linki",
  shortNote:"Kısa not",
  noOneYet:"Kimse yok.",
  noMatchYet:"Henüz eşleşme yok.",
  noSongsYet:"Henüz şarkı bırakılmadı.",
  noCitiesYet:"Şehir bilgisi yok.",
  noQuotesYet:"Henüz söz bırakılmadı.",
  sentSongOk:"✅ Şarkı bırakıldı.",
  sentQuoteOk:"✅ Söz bırakıldı.",
  cityLabel:"Şehir",
  stageLabel:"Şu an",
  stageUnspecified:"Belirtme",
  stageCurrent:"Şu an",
  leavePrivateNote:"Sana özel kısa not bırak",
  leavePrivateNotePh:"Herkese açık olmayan kısa bir not bırak...",
  privateNoteBtn:"Not Bırak",
  privateNoteSent:"✅ Not bırakıldı.",
  privateNotesTitle:"Sana Bırakılan Notlar",
  noPrivateNotes:"Henüz özel not yok.",
  profilePulseTitle:"Profil Nabzı",
  profileActiveArea:"Bu ay en aktif olduğu alan",
  profileLastSong:"Son bıraktığı şarkı",
  profileLastOrbit:"Son katıldığı Orbit",
  profileLastRating:"Son aldığı yıldız puanı",
  profilePrivateNoteCount:"Özel not sayısı",
  profileAchievements:"Mini başarı alanı",
  activeAreaPhotos:"Fotoğraflar",
  activeAreaFarewells:"Vedalar",
  activeAreaOrbit:"Orbit",
  activeAreaMemories:"Anı Duvarı",
  activeAreaNotes:"Özel Notlar",
  activeAreaQuiet:"Sakin",
  orbitAsHost:"İlan sahibi olarak",
  orbitAsGuest:"Katılımcı olarak",
  noTrackYet:"Henüz şarkı bırakılmadı.",
  noOrbitYet:"Henüz Orbit etkinliği yok.",
  noRatingYet:"Henüz puan yok.",
  noAchievementsYet:"Henüz rozet yok.",
  meetHistoryTitle:"Katıldığım Etkinlikler",
  meetHistoryDesc:"Daha önce katıldığın etkinliklerin kısa geçmişi.",
  meetNoHistory:"Henüz katıldığın etkinlik yok.",
  meetTrustLabel:"Güven puanı",
  meetCompletedHost:"Tamamlanan etkinlik",
  meetHostedTotal:"Açtığı ilan",
  meetHostCardTitle:"İlan sahibi kartı",
  meetHostExperience:"Daha önce etkinlik yaptı",
  meetHistoryJoined:"Katıldım",
  profileHeroEyebrowText:"MEra Profile",
  editCover:"Kapak Fotoğrafı",
  profileBioEmptySelf:"Profilini düzenleyip kendini anlat.",
  profileBioEmptyOther:"Henüz biyografi eklenmemiş.",
  followRequestsSmall:"Takip İstekleri",
  unreadDmSmall:"Okunmadı DM",
  verifiedTitle:"Doğrulanmış",
  classBadgeDefault:"Sınıf",
  schoolBadgeDefault:"Okul",
  trustStrong:"Güçlü",
  trustGrowing:"Yükseliyor",
  trustNew:"Yeni",
  quoteTypePeriod:"Dönem",
  quoteTypeTeacher:"Öğretmen",
  roomGroupCreate:"${t('roomGroupCreate')}",
  roomEmpty:"Bu odada henüz paylaşım yok.",
  roomNoMatch:"Eşleşme yok.",
  capsuleEmpty:"Henüz kapsül yok.",
  capsuleOpen:"Aç",
  capsuleReady:"Açılabilir",
  capsuleLocked:"Kilitli"
});
Object.assign(I18N.en, {
  novaTitle:"MEra Nova",
  novaDesc:"Time capsule, cohort map, rooms, memory wall, and class yearbook in one place.",
  novaTabCapsule:"⏳ Time Capsule",
  novaTabMap:"🗺️ Cohort Map",
  novaTabRooms:"🫂 Rooms",
  novaTabWall:"🧠 Memory Wall",
  novaTabYearbook:"📘 Yearbook",
  schoolNamePh:"School name",
  yearbookTitle:"Class Yearbook",
  yearbookLoad:"Load Yearbook",
  yearbookFriendsMatches:"Cohort friends and matches",
  yearbookSameClass:"People in Your Class",
  yearbookSameSchool:"Others From Your School",
  yearbookMatches:"Shared memory matches",
  yearbookPlaylistTitle:"Cohort Playlist",
  yearbookAddSong:"Leave a Song",
  yearbookSongNotePh:"Why does this song describe your era?",
  yearbookQuoteTitle:"Era / Teacher Quote",
  yearbookQuoteType:"Quote type",
  yearbookQuotePeriod:"Era quote",
  yearbookQuoteTeacher:"Teacher quote",
  yearbookQuoteBody:"Quote",
  yearbookQuotePh:"Leave a short quote worth remembering",
  yearbookQuoteAdd:"Leave Quote",
  yearbookAwards:"Highlights",
  yearbookTopTalker:"Most talkative in class",
  yearbookTopFarewell:"Most farewell messages",
  yearbookTopPhotos:"Most photo posts",
  yearbookThemeSong:"Song of the era",
  yearbookQuotesList:"Quotes",
  cityPresenceTitle:"Where Is Everyone Today?",
  songLinkLabel:"Song link",
  shortNote:"Short note",
  noOneYet:"No one yet.",
  noMatchYet:"No match yet.",
  noSongsYet:"No songs yet.",
  noCitiesYet:"No city info yet.",
  noQuotesYet:"No quotes yet.",
  sentSongOk:"✅ Song added.",
  sentQuoteOk:"✅ Quote added.",
  cityLabel:"City",
  stageLabel:"Current stage",
  stageUnspecified:"Prefer not to say",
  stageCurrent:"Current stage",
  leavePrivateNote:"Leave a private note",
  leavePrivateNotePh:"Leave a short note that is not public...",
  privateNoteBtn:"Send Note",
  privateNoteSent:"✅ Note sent.",
  privateNotesTitle:"Private notes left for you",
  noPrivateNotes:"No private notes yet.",
  profilePulseTitle:"Profile Pulse",
  profileActiveArea:"Most active area this month",
  profileLastSong:"Latest song left",
  profileLastOrbit:"Latest Orbit activity",
  profileLastRating:"Latest star rating received",
  profilePrivateNoteCount:"Private note count",
  profileAchievements:"Mini achievement area",
  activeAreaPhotos:"Photos",
  activeAreaFarewells:"Farewells",
  activeAreaOrbit:"Orbit",
  activeAreaMemories:"Memory Wall",
  activeAreaNotes:"Private Notes",
  activeAreaQuiet:"Quiet month",
  orbitAsHost:"As the host",
  orbitAsGuest:"As a guest",
  noTrackYet:"No song yet.",
  noOrbitYet:"No Orbit activity yet.",
  noRatingYet:"No rating yet.",
  noAchievementsYet:"No badges yet.",
  meetHistoryTitle:"Events I Joined",
  meetHistoryDesc:"A quick history of the events you joined before.",
  meetNoHistory:"You have not joined any events yet.",
  meetTrustLabel:"Trust score",
  meetCompletedHost:"Completed events",
  meetHostedTotal:"Listings created",
  meetHostCardTitle:"Host card",
  meetHostExperience:"Has hosted events before",
  meetHistoryJoined:"Joined",
  profileHeroEyebrowText:"MEra Profile",
  editCover:"Cover Photo",
  profileBioEmptySelf:"Edit your profile and tell your story.",
  profileBioEmptyOther:"No biography yet.",
  followRequestsSmall:"Follow Requests",
  unreadDmSmall:"Unread DMs",
  verifiedTitle:"Verified",
  classBadgeDefault:"Class",
  schoolBadgeDefault:"School",
  trustStrong:"Strong",
  trustGrowing:"Growing",
  trustNew:"New",
  quoteTypePeriod:"Era",
  quoteTypeTeacher:"Teacher",
  roomGroupCreate:"Create Group from Room",
  roomEmpty:"There are no posts in this room yet.",
  roomNoMatch:"No matches found.",
  capsuleEmpty:"No capsules yet.",
  capsuleOpen:"Open",
  capsuleReady:"Ready to open",
  capsuleLocked:"Locked"
});

Object.assign(I18N.tr, {
  groupToolsTitle:"Grup araçları",
  groupMiniPoll:"Mini anket",
  groupPlanEvent:"Etkinlik planla",
  groupAlbumTitle:"Ortak medya albümü",
  groupNoMedia:"Henüz medya yok.",
  groupPollsTitle:"Mini anketler",
  groupNoPolls:"Henüz anket yok.",
  groupEventsTitle:"Etkinlik planı",
  groupNoEvents:"Henüz etkinlik yok.",
  groupRolesTitle:"Roller",
  groupNoLocation:"Konum yok",
  groupNoMembers:"Üye bilgisi yok.",
  groupMakeMember:"Üye yap",
  groupMakeAdmin:"Yönetici yap",
  groupPollQuestionPrompt:"Anket sorusu",
  groupPollOptionsPrompt:"Seçenekleri | ile ayır",
  groupEventTitlePrompt:"Etkinlik başlığı",
  groupEventDatePrompt:"Tarih (YYYY-MM-DD HH:MM)",
  groupEventLocationPrompt:"Konum (opsiyonel)",
  groupEventNotePrompt:"Kısa not (opsiyonel)"
});
Object.assign(I18N.en, {
  groupToolsTitle:"Group tools",
  groupMiniPoll:"Mini poll",
  groupPlanEvent:"Plan event",
  groupAlbumTitle:"Shared media album",
  groupNoMedia:"No media yet.",
  groupPollsTitle:"Mini polls",
  groupNoPolls:"No polls yet.",
  groupEventsTitle:"Event plan",
  groupNoEvents:"No events yet.",
  groupRolesTitle:"Roles",
  groupNoLocation:"No location",
  groupNoMembers:"No member info.",
  groupMakeMember:"Make member",
  groupMakeAdmin:"Make admin",
  groupPollQuestionPrompt:"Poll question",
  groupPollOptionsPrompt:"Separate options with |",
  groupEventTitlePrompt:"Event title",
  groupEventDatePrompt:"Date (YYYY-MM-DD HH:MM)",
  groupEventLocationPrompt:"Location (optional)",
  groupEventNotePrompt:"Short note (optional)"
});


Object.assign(I18N.tr, {
  home:'Ana Sayfa',
  sceneNav:'MEra Scene',
  homeEyebrow:'MEra ana alanı',
  homeGreetingFallback:'Hoş geldin.',
  homeStatusFallback:'Bugün burada neler oluyor, tek bakışta gör.',
  homeMiniStreak:'Ritim',
  homeMiniAlerts:'Yeni',
  homeMiniOrbit:'Orbit',
  homeAgendaEyebrow:'Günün akışı',
  homeAgendaTitle:'Gündem kartı',
  homeQuickEyebrow:'Hızlı geçiş',
  homeQuickTitle:'Premium kısayollar',
  homeFeedEyebrow:'Arkadaşlarında neler oluyor?',
  homeFeedTitle:'Canlı akış',
  homeSuggestEyebrow:'Sana uygun',
  homeSuggestTitle:'Akıllı öneriler',
  homeGreeting:'Hoş geldin, {name}',
  homeStatusReady:'Bugün MEra içinde neler olup bittiğini tek bakışta görüyorsun.',
  homeAgendaTopic:'Bugün en çok konuşulan konu',
  homeAgendaSong:"Bu haftanın soundtrack'i",
  homeAgendaOrbit:"Orbit'te öne çıkan etkinlik",
  homeAgendaFarewell:'En çok veda alan profil',
  homeAgendaScene:"Scene'de yükselen yapım",
  homeQuickProfile:'Profilim',
  homeQuickDm:'DM',
  homeQuickLegacy:'Eski Toprak',
  homeQuickOrbit:'Orbit',
  homeQuickScene:'Scene',
  homeSuggestPeople:'Tanıyor olabileceğin kişiler',
  homeSuggestEvents:'İlgini çekebilecek etkinlikler',
  homeSuggestScene:'Sana uygun Scene içerikleri',
  homeSuggestSchool:'Okulundan öne çıkan başlıklar',
  homeEmpty:'Henüz gösterilecek veri yok.',
  sceneEyebrow:'Film • dizi • müzik • replik',
  sceneTitle:'MEra Scene',
  sceneDesc:"Seni anlatan sahneyi, karakteri, repliği veya soundtrack'i bırak.",
  sceneCreateEyebrow:'Yeni bırak',
  sceneCreateTitle:'Scene gönderisi oluştur',
  sceneEntryType:'Gönderi türü',
  sceneTypeScene:'Sahne',
  sceneTypeQuote:'Replik',
  sceneTypeSoundtrack:'Soundtrack',
  sceneTypeCharacter:'Karakter',
  sceneMediaKind:'Tür',
  sceneMediaFilm:'Film',
  sceneMediaSeries:'Dizi',
  sceneMediaPlaylist:'Playlist',
  sceneMediaTitle:'Yapım / liste adı',
  sceneMediaTitlePh:'Örn: Interstellar',
  sceneCharacterLabel:'Karakter',
  sceneCharacterPh:'Örn: Don Draper',
  scenePostTitle:'Kısa başlık',
  scenePostTitlePh:'Beni anlatan sahne',
  sceneBody:'Metin',
  sceneBodyPh:'Bu sahne/replik/soundtrack seni neden anlatıyor?',
  scenePlatformLabel:'Platform',
  sceneSoundtrackUrl:'Link',
  scenePublish:'Scene’e bırak',
  sceneSidebarEyebrow:'Topluluk',
  sceneSidebarTitle:'Bu hafta neler öne çıkıyor?',
  sceneFeedEyebrow:'Akış',
  sceneFeedTitle:'MEra Scene duvarı',
  sceneWeeklyTheme:'Haftanın teması',
  sceneTopMedia:'En çok bırakılan yapımlar',
  sceneTopCharacters:'Öne çıkan karakterler',
  sceneTopReaction:'En çok kullanılan tepki',
  sceneRecentWatching:'Arkadaşların ne izliyor?',
  sceneReactFire:'Alev aldı',
  sceneReactGlow:'Çok iyi',
  sceneReactMood:'Bende de var',
  scenePublished:'✅ Scene gönderisi paylaşıldı.',
  sceneEmpty:'Henüz Scene gönderisi yok.',
  sceneTypeLabel_scene:'Sahne kartı',
  sceneTypeLabel_quote:'Replik duvarı',
  sceneTypeLabel_soundtrack:'Soundtrack kartı',
  sceneTypeLabel_character:'Karakter kartı',
  youLabel:'Sen',
  someoneLabel:'Biri',
  deletedLabel:'silindi',
  photoLabel:'foto',
  editedLabel:'düzenlendi',
  reply:'Yanıtla',
  edit:'Düzenle',
  delete:'Sil',
  seenLabel:'Görüldü',
  dmReplyTo:'Yanıtlanan mesaj',
  dashboardNow:'Şimdi',
  dashboardPulse:'yeni',
  homeScenePrompt:'Seni anlatan bir sahne bırak',
  homeNoTheme:'Tema yakında gelecek',
  homeOpen:'Aç',
});
Object.assign(I18N.en, {
  home:'Home',
  sceneNav:'MEra Scene',
  homeEyebrow:'MEra main area',
  homeGreetingFallback:'Welcome back.',
  homeStatusFallback:'See what is happening today at a glance.',
  homeMiniStreak:'Rhythm',
  homeMiniAlerts:'New',
  homeMiniOrbit:'Orbit',
  homeAgendaEyebrow:"Today's flow",
  homeAgendaTitle:'Agenda card',
  homeQuickEyebrow:'Quick access',
  homeQuickTitle:'Premium shortcuts',
  homeFeedEyebrow:'What is happening around your friends?',
  homeFeedTitle:'Live feed',
  homeSuggestEyebrow:'For you',
  homeSuggestTitle:'Smart suggestions',
  homeGreeting:'Welcome, {name}',
  homeStatusReady:'See what is moving inside MEra in one glance.',
  homeAgendaTopic:'Most talked-about topic today',
  homeAgendaSong:'Soundtrack of the week',
  homeAgendaOrbit:'Featured Orbit event',
  homeAgendaFarewell:'Most-farewelled profile',
  homeAgendaScene:'Rising title in Scene',
  homeQuickProfile:'My Profile',
  homeQuickDm:'DM',
  homeQuickLegacy:'Legacy',
  homeQuickOrbit:'Orbit',
  homeQuickScene:'Scene',
  homeSuggestPeople:'People you may know',
  homeSuggestEvents:'Events you may like',
  homeSuggestScene:'Scene picks for you',
  homeSuggestSchool:'Trending topics from your school',
  homeEmpty:'Nothing to show yet.',
  sceneEyebrow:'film • series • music • quotes',
  sceneTitle:'MEra Scene',
  sceneDesc:"Drop the scene, character, quote, or soundtrack that describes you.",
  sceneCreateEyebrow:'Create',
  sceneCreateTitle:'Create a Scene post',
  sceneEntryType:'Post type',
  sceneTypeScene:'Scene',
  sceneTypeQuote:'Quote',
  sceneTypeSoundtrack:'Soundtrack',
  sceneTypeCharacter:'Character',
  sceneMediaKind:'Format',
  sceneMediaFilm:'Film',
  sceneMediaSeries:'Series',
  sceneMediaPlaylist:'Playlist',
  sceneMediaTitle:'Title / list name',
  sceneMediaTitlePh:'Example: Interstellar',
  sceneCharacterLabel:'Character',
  sceneCharacterPh:'Example: Don Draper',
  scenePostTitle:'Short title',
  scenePostTitlePh:'The scene that describes me',
  sceneBody:'Text',
  sceneBodyPh:'Why does this scene/quote/soundtrack describe you?',
  scenePlatformLabel:'Platform',
  sceneSoundtrackUrl:'Link',
  scenePublish:'Post to Scene',
  sceneSidebarEyebrow:'Community',
  sceneSidebarTitle:'What is trending this week?',
  sceneFeedEyebrow:'Feed',
  sceneFeedTitle:'MEra Scene wall',
  sceneWeeklyTheme:'Theme of the week',
  sceneTopMedia:'Most shared titles',
  sceneTopCharacters:'Top characters',
  sceneTopReaction:'Top reaction',
  sceneRecentWatching:'What your friends are watching',
  sceneReactFire:'Fire',
  sceneReactGlow:'So good',
  sceneReactMood:"That's me",
  scenePublished:'✅ Scene post shared.',
  sceneEmpty:'No Scene posts yet.',
  sceneTypeLabel_scene:'Scene card',
  sceneTypeLabel_quote:'Quote wall',
  sceneTypeLabel_soundtrack:'Soundtrack card',
  sceneTypeLabel_character:'Character card',
  youLabel:'You',
  someoneLabel:'Someone',
  deletedLabel:'deleted',
  photoLabel:'photo',
  editedLabel:'edited',
  reply:'Reply',
  edit:'Edit',
  delete:'Delete',
  seenLabel:'Seen',
  dmReplyTo:'Replied message',
  dashboardNow:'Now',
  dashboardPulse:'new',
  homeScenePrompt:'Drop a scene that describes you',
  homeNoTheme:'Theme coming soon',
  homeOpen:'Open',
});

Object.assign(I18N.tr, {
  aboutEyebrow:"Manifesto • Premium deneyim • Hareket",
  aboutHeroLine1:"Mezuniyet burada",
  aboutHeroLine2:"dönüşür.",
  aboutWord1:"harekete",
  aboutWord2:"hafızaya",
  aboutWord3:"enerjiye",
  aboutWord4:"çağa",
  aboutSummary:"MEra; vedaları, okul enerjisini, mezuniyet hafızasını ve insanları tek ekranda sadece gösteren değil hissettiren dijital alan.",
  aboutExploreBtn:"Manifestoyu keşfet",
  aboutFinaleBtn:"Final satırına git",
  aboutChip1:"Sürünün parçası",
  aboutChip2:"Ortak hafıza",
  aboutChip3:"Premium kimlik",
  aboutChip4:"Yeni çağ enerjisi",
  aboutAsideEyebrow:"MEra hissi",
  aboutMetricMain:"Sadece bir profil değil.",
  aboutMetricBody:"Aynı yılı, aynı okulu ve aynı duyguyu yaşayan insanları ortak bir hafızada buluşturan dijital alan.",
  aboutMini1Title:"Anılar",
  aboutMini1Body:"saklanmaz",
  aboutMini2Title:"Bağlantılar",
  aboutMini2Body:"harekete dönüşür",
  aboutMini3Title:"Mezuniyet",
  aboutMini3Body:"yaşamaya devam eder",
  aboutManifestoEyebrow:"Manifesto",
  aboutManifestoTitle:"MEra’nın kalbi burada atıyor",
  aboutManifestoBody:"Bu bölüm sadece açıklama değil; markanın ruhunu, sürü hissini ve mezuniyet enerjisini gösteren sahne.",
  aboutStageEyebrow:"Sahneleme",
  aboutStageTitle:"Giren kişi açıklama değil atmosfer görmeli",
  aboutImpact1Badge:"Kimlik",
  aboutImpact1Title:"MEra ekrana ilk anda karakter verir",
  aboutImpact1Body:"Yumuşak glow, premium panel ve hareketli manifesto bloklarıyla bölüm hafızada kalır.",
  aboutImpact2Badge:"Duygu",
  aboutImpact2Title:"Sadece bilgi vermez, his bırakır",
  aboutImpact2Body:"Mezuniyet, arkadaşlık, anı ve bağ hissi ekrana katman katman yayılır.",
  aboutImpact3Badge:"Vurgu",
  aboutImpact3Title:"Her satır bir afiş gücünde görünür",
  aboutImpact3Body:"Büyük tipografi, sinematik geçiş ve aktif kart döngüsü wow etkisini büyütür.",
  aboutFinaleEyebrow:"Final",
  aboutFinaleBody:"Bu alan; mezuniyet yıllığını, sosyal bağı ve topluluk ruhunu tek bir imzada toplar.",
  aboutFinaleTag:"Bu senin dönemin. Bu senin çağın."
});
Object.assign(I18N.tr, {
  styleNav:'MEra Style',
  styleEyebrow:'Kombin • indirim • keşif',
  styleTitle:'MEra Style',
  styleDesc:'Kombinini paylaş, ürün indirimi yakala, topluluğa hızlıca haber ver.',
  styleHeroChip1:'Kombin paylaş',
  styleHeroChip2:'İndirim bildir',
  styleHeroChip3:'Ürünlerini ekle',
  styleCreateEyebrow:'Yeni paylaşım',
  styleCreateTitle:'Kombin ya da indirim bırak',
  stylePostType:'Paylaşım tipi',
  styleTypeOutfit:'Kombin',
  styleTypeDeal:'İndirim',
  styleCategory:'Kategori',
  styleCatSneaker:'Sneaker',
  styleCatStreetwear:'Streetwear',
  styleCatMakeup:'Makyaj',
  styleCatAccessory:'Aksesuar',
  styleTitleLabel:'Başlık',
  styleTitlePh:'Örn: Günlük gri-beyaz kombin',
  styleBrandLabel:'Marka / mağaza',
  styleBrandPh:'Örn: Nike / Gratis',
  stylePriceNow:'Yeni fiyat',
  stylePriceNowPh:'799',
  stylePriceBefore:'Eski fiyat',
  stylePriceBeforePh:'1199',
  styleLinkLabel:'Link',
  styleLinkPh:'https://...',
  styleTagsLabel:'Etiketler',
  styleTagsPh:'#dunk #indirim #softglam',
  styleBodyLabel:'Açıklama',
  styleBodyPh:'Parçaları, uyumu veya indirim bilgisini yaz.',
  styleImageLabel:'Fotoğraf (opsiyonel)',
  styleDealTitleLabel:'İndirim başlığı',
  styleDealTitlePh:'Örn: Nike Air indirimde',
  styleDealStoreLabel:'Mağaza / marka',
  styleDealStorePh:'Örn: Nike, Zara, Trendyol',
  styleDealPriceNow:'İndirimli fiyat',
  styleDealPriceNowPh:'799',
  styleDealPriceBefore:'İndirimsiz fiyat',
  styleDealPriceBeforePh:'1199',
  styleDealLinkLabel:'Ürün linki',
  styleDealLinkPh:'Ürünün direkt linki',
  styleDealTagsLabel:'İndirim etiketleri',
  styleDealTagsPh:'#indirim #sneaker #kaçmaz',
  styleDealBodyLabel:'İndirim notu',
  styleDealBodyPh:'Beden, mağaza, stok ve kampanya bilgisini yaz.',
  styleDealImageLabel:'Ürün fotoğrafı (opsiyonel)',
  stylePublish:'Paylaş',
  styleFeedEyebrow:'Akış',
  styleFeedTitle:'MEra Style akışı',
  styleTabAll:'Tümü',
  styleTabOutfits:'Kombinler',
  styleTabDeals:'İndirim Alarmı',
  styleTabSaved:'Favorilerim',
  styleSummaryTitle:'Bugün Style alanında',
  styleSummaryBody:'Kombin paylaş, ürün öner, indirim yakalayınca topluluğa saniyesinde haber ver.',
  styleSummaryDeals:'En yeni indirimler',
  styleSummaryOutfits:'En yeni kombinler',
  homeDealsEyebrow:'En iyi indirimler',
  homeDealsTitle:'Fiyatına oranla en iyi 5 ürün',
  homeStyleTopEyebrow:'Style sıralaması',
  homeStyleTopTitle:'Günün / ayın / yılın kombinleri',
  homeDealScore:'İndirim skoru',
  homeDealEmpty:'Henüz yeterli indirim ürünü yok.',
  homeOutfitDay:'Günün kombini',
  homeOutfitMonth:'Ayın kombini',
  homeOutfitYear:'Yılın kombini',
  homeOutfitEmpty:'Henüz yeterli kombin yok.',
  styleModeOutfitTitle:'Kombin modunda paylaş',
  styleModeOutfitBody:'Parçaları ekle, uyumu anlat ve beğeni topla.',
  styleModeDealTitle:'İndirim alarmı bırak',
  styleModeDealBody:'Fiyat farkını, mağazayı ve linki net şekilde göster.',
  styleSpotlightOutfit:'Kombin tarafı',
  styleSpotlightDeal:'İndirim tarafı',
  styleSpotlightOutfitBody:'Görsel, ürün kutusu ve stil notu öne çıkar.',
  styleSpotlightDealBody:'İndirim yüzdesi, fiyat skoru ve mağaza filtresi öne çıkar.',
  styleDealFocusTitle:'Deal modu aktif',
  styleOutfitFocusTitle:'Kombin modu aktif',
  styleDealFocusBody:'Burada yüzdeler, fiyat farkı ve link daha baskın görünür.',
  styleOutfitFocusBody:'Burada görsel uyum, parçalar ve kaydetme hissi öne çıkar.',
  styleEmpty:'Henüz paylaşım yok.',
  stylePublished:'✅ Style paylaşımı eklendi.',
  styleTrendLabel:'Yükselen etiketler',
  styleSaveHint:'Style alanında ürünler, kombinler ve indirim haberleri karışık akar.',
  styleSeeProduct:'Linke git',
  styleDiscountBadge:'İndirim',
  styleOutfitBadge:'Kombin',
  styleItemsLabel:'Bu kombindeki ürünler',
  styleItemsLabelDeal:'Bu paylaşımda geçen ürünler',
  styleAddItem:'+ Ürün ekle',
  styleItemName:'Ürün adı',
  styleItemStore:'Mağaza',
  styleItemPrice:'Fiyat',
  styleItemLink:'Link',
  styleDiscoverEyebrow:'Keşfet',
  styleDiscoverTitle:'Kolay filtreler ve öne çıkanlar',
  styleGuideTitle:'Burada neler yapabilirsin?',
  styleGuideBody:'Kombin bak, kaydet, beğen, ürün parçalarını gör ve indirimleri mağazaya göre filtrele.',
  styleStoreFilterTitle:'Mağazaya göre filtrele',
  styleCarouselTitle:'Öne çıkan kartlar',
  styleLike:'Beğen',
  styleSave:'Kaydet',
  styleSaved:'Kaydedildi',
  styleLiked:'Beğenildi',
  styleProductsBox:'Bu kombindeki ürünler',
  styleProductsBoxDeal:'Bu paylaşımda geçen ürünler',
  styleFeatured:'Öne çıkan',
  styleAllStores:'Tüm mağazalar',
  styleNoStore:'Mağaza yok',
  styleNoTitle:'Başlıksız',
  styleRemove:'Kaldır',
  styleDealDiscountLabel:'İndirim',
  styleDealSavingLabel:'Kazanç',
  styleDealNoDiscount:'Yok',
  styleDealLinkRequired:'İndirim paylaşmak için ürün linki gerekli.',
  styleDealPriceRequired:'İndirim için eski fiyat, yeni fiyattan yüksek olmalı.',
  styleLiveDiscount:'Otomatik indirim',
  styleLiveSaving:'Kazanç',
  styleLiveNoDiscount:'Eski ve yeni fiyatı girince indirim otomatik hesaplanır.',
  styleFavoriteAdded:'Favorilere eklendi.',
  styleFavoriteRemoved:'Favorilerden çıkarıldı.'
});
Object.assign(I18N.en, {
  styleNav:'MEra Style',
  styleEyebrow:'Outfits • deals • discovery',
  styleTitle:'MEra Style',
  styleDesc:'Share your outfit, catch product deals, and alert the community fast.',
  styleHeroChip1:'Share outfits',
  styleHeroChip2:'Post deals',
  styleHeroChip3:'Add products',
  styleCreateEyebrow:'New post',
  styleCreateTitle:'Drop an outfit or a deal',
  stylePostType:'Post type',
  styleTypeOutfit:'Outfit',
  styleTypeDeal:'Deal',
  styleCategory:'Category',
  styleCatSneaker:'Sneaker',
  styleCatStreetwear:'Streetwear',
  styleCatMakeup:'Makeup',
  styleCatAccessory:'Accessory',
  styleTitleLabel:'Title',
  styleTitlePh:'Example: Everyday grey-white fit',
  styleBrandLabel:'Brand / store',
  styleBrandPh:'Example: Nike / Sephora',
  stylePriceNow:'New price',
  stylePriceNowPh:'799',
  stylePriceBefore:'Previous price',
  stylePriceBeforePh:'1199',
  styleLinkLabel:'Link',
  styleLinkPh:'https://...',
  styleTagsLabel:'Tags',
  styleTagsPh:'#dunk #sale #softglam',
  styleBodyLabel:'Description',
  styleBodyPh:'Write the pieces, vibe, or discount details.',
  styleImageLabel:'Image (optional)',
  styleDealTitleLabel:'Deal title',
  styleDealTitlePh:'Example: Nike Air on sale',
  styleDealStoreLabel:'Store / brand',
  styleDealStorePh:'Example: Nike, Zara, Trendyol',
  styleDealPriceNow:'Sale price',
  styleDealPriceNowPh:'799',
  styleDealPriceBefore:'Regular price',
  styleDealPriceBeforePh:'1199',
  styleDealLinkLabel:'Product link',
  styleDealLinkPh:'Direct product link',
  styleDealTagsLabel:'Deal tags',
  styleDealTagsPh:'#deal #sneaker #mustsee',
  styleDealBodyLabel:'Deal note',
  styleDealBodyPh:'Add size, store, stock, and campaign details.',
  styleDealImageLabel:'Product photo (optional)',
  stylePublish:'Share',
  styleFeedEyebrow:'Feed',
  styleFeedTitle:'MEra Style feed',
  styleTabAll:'All',
  styleTabOutfits:'Outfits',
  styleTabDeals:'Deal Alerts',
  styleTabSaved:'Favorites',
  styleSummaryTitle:'Today in Style',
  styleSummaryBody:'Share outfits, suggest products, and alert the community the second a discount appears.',
  styleSummaryDeals:'Latest deals',
  styleSummaryOutfits:'Latest outfits',
  homeDealsEyebrow:'Best deals',
  homeDealsTitle:'Top 5 products by price ratio',
  homeStyleTopEyebrow:'Style ranking',
  homeStyleTopTitle:'Day / month / year outfits',
  homeDealScore:'Deal score',
  homeDealEmpty:'No strong deal products yet.',
  homeOutfitDay:'Outfit of the day',
  homeOutfitMonth:'Outfit of the month',
  homeOutfitYear:'Outfit of the year',
  homeOutfitEmpty:'No strong outfits yet.',
  styleModeOutfitTitle:'Post in outfit mode',
  styleModeOutfitBody:'Add pieces, explain the match, and collect saves.',
  styleModeDealTitle:'Drop a deal alert',
  styleModeDealBody:'Show price gap, store, and product link clearly.',
  styleSpotlightOutfit:'Outfit side',
  styleSpotlightDeal:'Deal side',
  styleSpotlightOutfitBody:'Visual harmony, product box, and style note lead here.',
  styleSpotlightDealBody:'Discount percent, price score, and store filter lead here.',
  styleDealFocusTitle:'Deal mode active',
  styleOutfitFocusTitle:'Outfit mode active',
  styleDealFocusBody:'Percentages, price gap, and link become dominant here.',
  styleOutfitFocusBody:'Visual harmony, pieces, and save feeling stand out here.',
  styleEmpty:'No posts yet.',
  stylePublished:'✅ Style post shared.',
  styleTrendLabel:'Rising tags',
  styleSaveHint:'Style mixes products, outfit ideas, and discount alerts in one stream.',
  styleSeeProduct:'Open link',
  styleDiscountBadge:'Deal',
  styleOutfitBadge:'Outfit',
  styleItemsLabel:'Products in this outfit',
  styleItemsLabelDeal:'Products mentioned in this post',
  styleAddItem:'+ Add product',
  styleItemName:'Product name',
  styleItemStore:'Store',
  styleItemPrice:'Price',
  styleItemLink:'Link',
  styleDiscoverEyebrow:'Discover',
  styleDiscoverTitle:'Easy filters and highlights',
  styleGuideTitle:'What can you do here?',
  styleGuideBody:'Browse outfits, save favorites, like posts, view product pieces, and filter deals by store.',
  styleStoreFilterTitle:'Filter by store',
  styleCarouselTitle:'Featured cards',
  styleLike:'Like',
  styleSave:'Save',
  styleSaved:'Saved',
  styleLiked:'Liked',
  styleProductsBox:'Products in this outfit',
  styleProductsBoxDeal:'Products in this post',
  styleFeatured:'Featured',
  styleAllStores:'All stores',
  styleNoStore:'No store',
  styleNoTitle:'Untitled',
  styleRemove:'Remove',
  styleDealDiscountLabel:'Discount',
  styleDealSavingLabel:'You save',
  styleDealNoDiscount:'None',
  styleDealLinkRequired:'A product link is required for deal posts.',
  styleDealPriceRequired:'Regular price must be higher than sale price.',
  styleLiveDiscount:'Auto discount',
  styleLiveSaving:'You save',
  styleLiveNoDiscount:'Enter regular and sale prices to calculate the discount automatically.',
  styleFavoriteAdded:'Added to favorites.',
  styleFavoriteRemoved:'Removed from favorites.'
});

Object.assign(I18N.en, {
  aboutEyebrow:"Manifesto • Premium experience • Motion",
  aboutHeroLine1:"Graduation turns into",
  aboutHeroLine2:"here.",
  aboutWord1:"movement",
  aboutWord2:"memory",
  aboutWord3:"energy",
  aboutWord4:"an era",
  aboutSummary:"MEra is a digital space that does not just show farewells, school energy, graduation memories, and people on one screen — it makes you feel them.",
  aboutExploreBtn:"Explore the manifesto",
  aboutFinaleBtn:"Jump to the final line",
  aboutChip1:"Part of the pack",
  aboutChip2:"Shared memory",
  aboutChip3:"Premium identity",
  aboutChip4:"New era energy",
  aboutAsideEyebrow:"The MEra feeling",
  aboutMetricMain:"Not just a profile.",
  aboutMetricBody:"A shared digital memory space that brings together people who lived the same year, the same school, and the same emotion.",
  aboutMini1Title:"Memories",
  aboutMini1Body:"do not just stay stored",
  aboutMini2Title:"Connections",
  aboutMini2Body:"turn into motion",
  aboutMini3Title:"Graduation",
  aboutMini3Body:"keeps living on",
  aboutManifestoEyebrow:"Manifesto",
  aboutManifestoTitle:"The heart of MEra beats here",
  aboutManifestoBody:"This section is not just an explanation; it is the stage where the brand spirit, pack feeling, and graduation energy show up.",
  aboutStageEyebrow:"Staging",
  aboutStageTitle:"Visitors should feel an atmosphere, not read a plain description",
  aboutImpact1Badge:"Identity",
  aboutImpact1Title:"MEra gives the screen character at first glance",
  aboutImpact1Body:"Soft glow, premium panels, and moving manifesto blocks make the section memorable.",
  aboutImpact2Badge:"Emotion",
  aboutImpact2Title:"It does not only inform, it leaves a feeling",
  aboutImpact2Body:"Graduation, friendship, memory, and connection spread across the screen in layers.",
  aboutImpact3Badge:"Impact",
  aboutImpact3Title:"Each line lands with poster-level power",
  aboutImpact3Body:"Large typography, cinematic transitions, and the active card cycle amplify the wow effect.",
  aboutFinaleEyebrow:"Finale",
  aboutFinaleBody:"This area gathers the graduation yearbook, the social bond, and the spirit of community into one signature moment.",
  aboutFinaleTag:"This is your era. This is your age.",
  orbitHeaderMeta:"Tap • pick • go",
  orbitSelectedLabel:"SELECTED ROUTE",
  orbitRouteEyebrow:"ACTIVE ROUTE",
  orbitGo:"Go",
  orbitQuickDashboard:"Main flow",
  orbitQuickStudents:"Students",
  orbitQuickMessages:"Messages",
  orbitQuickManifesto:"Manifesto",
  orbitTutorialEyebrow:"FIRST USE",
  orbitTutorialTitle:"How does Card Orbit work?",
  orbitTutorialText:"Tap or click a card to bring it forward and select it. Use the center Go button to open it, or move through areas with the left-right arrows.",
  orbitTutorialDismiss:"Got it",
  orbitCoreDefaultHint:"Pick a card, then press Go.",
  orbitHintDashboard:"Main flow, summary cards, and quick jumps live here.",
  orbitHintDirectory:"Filter people and jump into profiles quickly.",
  orbitHintProfile:"Profile layout, photos, and links in one place.",
  orbitHintPet:"Grow, feed, and manage shared avatars.",
  orbitHintLegacy:"Community talk and the live feed spin here.",
  orbitHintGossip:"The hottest conversations and trend stream are here.",
  orbitHintDm:"Jump straight into private messages.",
  orbitHintMeet:"The central route for connection and interaction.",
  orbitHintNova:"A more energetic flow and discovery area.",
  orbitHintScene:"Stage, content, and visual sharing area.",
  orbitHintStyle:"Outfits, deals, and style flow are here.",
  orbitHintAbout:"The manifesto, era, and brand feeling live here.",
  orbitDescDashboard:"Today overview",
  orbitDescDirectory:"Discover people",
  orbitDescProfile:"Your space",
  orbitDescPet:"Avatar care",
  orbitDescLegacy:"Community flow",
  orbitDescGossip:"Hot talk",
  orbitDescDm:"Jump to messages",
  orbitDescMeet:"Meet and connect",
  orbitDescNova:"New rooms",
  orbitDescScene:"Scene stream",
  orbitDescStyle:"Outfits & deals",
  orbitDescAbout:"Open manifesto"
});


function t(k){ return (I18N[lang] && I18N[lang][k]) || I18N.tr[k] || k; }
function homeText(k){
  const dict = {
    tr:{
      emptySceneTitle:'Scene sahneni aç', emptySceneBody:'Film, dizi ve şarkı izlerini ekleyince akış burada canlanır.',
      emptyOrbitTitle:'İlk Orbit’i kur', emptyOrbitBody:'Kahve, çalışma veya etkinlik planı aç; arkadaşların burada görsün.',
      emptyLegacyTitle:'Bir anı bırak', emptyLegacyBody:'Eski Toprak’a ilk mesajı yazınca ana sayfa dolmaya başlar.',
      emptyStyleTitle:'Stilini paylaş', emptyStyleBody:'Kombin veya indirim ekle; en iyiler ana sayfada parlasın.',
      dealEmptyTitle:'İndirim vitrini hazır', dealEmptyBody:'Fiyatı ve önceki fiyatı girilen fırsatlar burada en iyi skora göre sıralanır.',
      outfitEmptyTitle:'Podyum boş bekliyor', outfitEmptyBody:'Günün, ayın ve yılın kombini için Style’a ilk kombini ekle.',
      noNoticeTitle:'Her şey sakin', noNoticeBody:'Yeni takip, DM veya sistem bildirimi geldiğinde burada görünecek.',
      noNoticePeopleTitle:'İnsanları keşfet', noNoticePeopleBody:'Okulundan kişileri bul, takip isteği gönder ve akışı hareketlendir.',
    },
    en:{
      emptySceneTitle:'Open your Scene', emptySceneBody:'Add movies, shows and songs; this feed will come alive.',
      emptyOrbitTitle:'Create the first Orbit', emptyOrbitBody:'Start a coffee, study or event plan and let friends see it here.',
      emptyLegacyTitle:'Leave a memory', emptyLegacyBody:'Write the first Legacy message to start filling the homepage.',
      emptyStyleTitle:'Share your style', emptyStyleBody:'Add an outfit or deal; the best ones shine on the homepage.',
      dealEmptyTitle:'Deal showcase ready', dealEmptyBody:'Deals with current and old prices will rank here by score.',
      outfitEmptyTitle:'The runway is waiting', outfitEmptyBody:'Add the first Style outfit for daily, monthly and yearly picks.',
      noNoticeTitle:'All quiet', noNoticeBody:'New follows, DMs or system alerts will appear here.',
      noNoticePeopleTitle:'Discover people', noNoticePeopleBody:'Find schoolmates, send follow requests and wake up the feed.',
    }
  };
  return (dict[lang] && dict[lang][k]) || dict.tr[k] || k;
}
function setLanguage(next){ lang = next === "en" ? "en" : "tr"; localStorage.setItem(LANG_KEY, lang); document.documentElement.lang = lang; applyLanguage(); bindAuthEnhancements(); if(selectedUser){ profileHeader.innerHTML = profileHeaderHtml(selectedUser); renderProfilePanel(selectedUser); } if(currentView==="dashboard" && me) loadDashboard().catch(()=>{}); if(currentView==="scene" && me) loadScene().catch(()=>{}); if(currentView==="style" && me) loadStyle().catch(()=>{}); if(currentView==="about") activateAboutExperience(); else stopAboutExperience(); }
function applyLanguage(){
  const setText=(id,key)=>{ const el=$(id); if(!el) return; const label = el.querySelector('.js-label'); if(label) label.textContent=t(key); else el.textContent=t(key); };
  const setPh=(id,key)=>{ const el=$(id); if(el) el.placeholder=t(key); };
  [btnLangTR,btnLangTRAuth].filter(Boolean).forEach(el=>{ el.classList.toggle("active",lang==="tr"); el.textContent="TR"; el.setAttribute("aria-pressed", lang==="tr" ? "true" : "false"); });
  [btnLangEN,btnLangENAuth].filter(Boolean).forEach(el=>{ el.classList.toggle("active",lang==="en"); el.textContent="EN"; el.setAttribute("aria-pressed", lang==="en" ? "true" : "false"); });
  setText("btnLogout","logout"); setText("btnHome","home"); setText("btnDirectory","students"); setText("btnMyProfile","myProfile"); setText("btnLegacy","legacy"); setText("btnDM","dm"); if(btnMeet) setText("btnMeet","meet"); setText("btnScene","sceneNav"); if(btnStyle) setText("btnStyle","styleNav"); if(btnPsy) btnPsy.textContent=""; setText("btnAbout","about");
  document.querySelectorAll('[data-i18n]').forEach(el=>{ const key = el.dataset.i18n; if(key) el.textContent = t(key); });
  document.querySelectorAll('[data-i18n-placeholder]').forEach(el=>{ const key = el.dataset.i18nPlaceholder; if(key) el.placeholder = t(key); });
  document.querySelectorAll('[data-i18n-title]').forEach(el=>{ const key = el.dataset.i18nTitle; if(key) el.title = t(key); });
  setPh("search","search"); setPh("filterSchool","schoolFilter"); if(filterYear && filterYear.options.length) filterYear.options[0].textContent=t("yearAll");
  setPh("dmSearch","searchDm"); setText("btnDmClearSearch","clear"); setPh("dmInput","writeMsg"); setText("btnDmSend","send");
  if(btnCreateDmGroup) btnCreateDmGroup.textContent = t('createGroup');
  if(btnCloseDmGroup) btnCloseDmGroup.textContent = t('close');
  const dmGroupTitleEl = document.querySelector('#dmGroupModal h2'); if(dmGroupTitleEl) dmGroupTitleEl.textContent = t('groupCreateTitle');
  const dmGroupHintEl = document.querySelector('#dmGroupModal p'); if(dmGroupHintEl) dmGroupHintEl.textContent = t('groupCreateHint');
  setPh('dmGroupName','groupName'); setPh('dmGroupSpotify','groupLink'); setPh('dmGroupDesc','groupDesc'); setPh('dmGroupSearch','groupSearch');
  if(btnDmGroupSave) btnDmGroupSave.textContent = t('groupCreateBtn');
  const dmMembersTitle = document.querySelector('.dmGroupPickerHead h3'); if(dmMembersTitle) dmMembersTitle.textContent = t('groupMembers');
  const dmPhotoText = document.querySelector('label[for="dmGroupPhoto"] .dmAttachText'); if(dmPhotoText) dmPhotoText.textContent = t('groupPhoto');
  if(currentConversationId && currentDmThreadMeta) setDmHeader(currentDmThreadMeta);
  else if(!currentConversationId && dmWith) dmWith.textContent=t("chooseChat");
  const chatsTitle=document.querySelector("#dmCard h3"); if(chatsTitle) chatsTitle.textContent=t("chats");
  if(editingMeetupId && $("btnCreateMeetup")) $("btnCreateMeetup").textContent = t('meetUpdate');
  if($("meetDatePreview")) $("meetDatePreview").textContent = formatMeetDatePreview(confirmedMeetDate || $("meetDateInput")?.value || '');
  setOrbitInfo(orbitViewMeta(orbitButtonToView(getOrbitButtons().find(btn=>btn.id === orbitSelectedId) || getOrbitButtonByView(currentView))));
  syncOrbitCardDescriptions();
  document.title = lang === 'en' ? 'MEra' : 'MEra';
}


let aboutWordTimer = null;
let aboutManifestoTimer = null;

function initAboutExperience(){
  if(!aboutCard || aboutCard.dataset.aboutInit === '1') return;
  aboutCard.dataset.aboutInit = '1';
  const bindScroll = (id, targetId)=>{
    const btn = $(id);
    const target = $(targetId);
    if(btn && target) btn.addEventListener('click', ()=>{ try{ target.scrollIntoView({behavior:'smooth', block:'start'}); }catch(_){ target.scrollIntoView(); } });
  };
  bindScroll('btnAboutManifesto','aboutManifesto');
  bindScroll('btnAboutFinale','aboutFinaleSection');

  aboutCard.querySelectorAll('.aboutTiltCard').forEach(card=>{
    if(card.dataset.tiltBound === '1') return;
    card.dataset.tiltBound = '1';
    card.addEventListener('mousemove', (e)=>{
      const rect = card.getBoundingClientRect();
      const px = (e.clientX - rect.left) / Math.max(rect.width, 1);
      const py = (e.clientY - rect.top) / Math.max(rect.height, 1);
      const rx = (0.5 - py) * 8;
      const ry = (px - 0.5) * 10;
      card.style.transform = `perspective(1200px) rotateX(${rx.toFixed(2)}deg) rotateY(${ry.toFixed(2)}deg) translateY(-3px)`;
    });
    card.addEventListener('mouseleave', ()=>{ card.style.transform = ''; });
  });
}

function stopAboutExperience(){
  if(aboutWordTimer){ clearInterval(aboutWordTimer); aboutWordTimer = null; }
  if(aboutManifestoTimer){ clearInterval(aboutManifestoTimer); aboutManifestoTimer = null; }
  aboutCard?.querySelectorAll('[data-about-card]').forEach(card=>card.classList.remove('is-active'));
}

function activateAboutExperience(){
  initAboutExperience();
  stopAboutExperience();
  const wordEl = $('aboutWord');
  const wordKeys = ['aboutWord1','aboutWord2','aboutWord3','aboutWord4'];
  let wordIdx = 0;
  if(wordEl){
    wordEl.textContent = t(wordKeys[wordIdx]);
    aboutWordTimer = setInterval(()=>{
      wordIdx = (wordIdx + 1) % wordKeys.length;
      wordEl.style.opacity = '0';
      wordEl.style.transform = 'translateY(6px) scale(.98)';
      setTimeout(()=>{
        wordEl.textContent = t(wordKeys[wordIdx]);
        wordEl.style.opacity = '1';
        wordEl.style.transform = '';
      }, 160);
    }, 2400);
  }

  const cards = Array.from(aboutCard?.querySelectorAll('[data-about-card]') || []);
  if(cards.length){
    let activeIdx = 1 % cards.length;
    cards[0].classList.add('is-active');
    aboutManifestoTimer = setInterval(()=>{
      cards.forEach((card, idx)=>card.classList.toggle('is-active', idx===activeIdx));
      activeIdx = (activeIdx + 1) % cards.length;
    }, 2200);
  }
}

function setMsg(el, t){ if(el) el.textContent = t || ""; }
function getToken(){ return localStorage.getItem(TOKEN_KEY); }
function setToken(t){ if(t) localStorage.setItem(TOKEN_KEY,t); else localStorage.removeItem(TOKEN_KEY); }

const ACTIVE_USER_KEY = "mera_active_user_id";
function userScopedKey(base){ return me?.id ? `${base}_u${me.id}` : base; }
function resetVolatileUserUiState(){
  currentView = "dashboard";
  selectedUser = null;
  navStack = [];
  gossipMode = "all";
  if(gossipVisibility) gossipVisibility.value = "global";
  if(gossipSort) gossipSort.value = "new";
  if(gossipFilterCategory) gossipFilterCategory.value = "all";
  document.querySelectorAll('[data-gossip-mode]').forEach(b=>b.classList.toggle('active', b.dataset.gossipMode === 'all'));
  if(search) search.value = "";
  if(filterSchool) filterSchool.value = "";
  if(filterYear) filterYear.value = "";
  if(dmSearch) dmSearch.value = "";
  if(legacyInput) legacyInput.value = "";
  if(gossipText) gossipText.value = "";
  if(blastState){ blastState.loaded = false; blastState.activeGame = 'blast'; }
}
function activateUserSession(user){
  const id = user?.id ? String(user.id) : "";
  const prev = localStorage.getItem(ACTIVE_USER_KEY) || "";
  if(id && prev !== id) resetVolatileUserUiState();
  if(id) localStorage.setItem(ACTIVE_USER_KEY, id);
}
function clearUserSessionState(){
  localStorage.removeItem(ACTIVE_USER_KEY);
  resetVolatileUserUiState();
}

function openDrawer(){
  if(!drawer || !drawerOverlay) return;
  drawer.classList.remove('hidden');
  drawerOverlay.classList.remove('hidden');
  highlightSimpleMenu(currentView || 'dashboard');
}
function closeDrawer(){
  if(!drawer || !drawerOverlay) return;
  drawer.classList.add('hidden');
  drawerOverlay.classList.add('hidden');
}

function getOrbitButtons(){
  return Array.from(document.querySelectorAll(".orbitItem:not(.hidden)"));
}

function highlightSimpleMenu(view){
  document.querySelectorAll('.simpleMenuItem').forEach(btn=>{
    btn.classList.toggle('is-active', (btn.dataset.view || '') === view);
  });
}

function orbitButtonToView(btn){
  if(!btn) return currentView || 'dashboard';
  return btn.dataset.view || (btn===btnHome ? 'dashboard' : btn===btnDirectory ? 'directory' : btn===btnMyProfile ? 'profile' : btn===btnPet ? 'pet' : btn===btnLegacy ? 'legacy' : btn===btnGossip ? 'gossip' : btn===btnDM ? 'dm' : btn===btnMeet ? 'meet' : btn===btnNova ? 'nova' : btn===btnScene ? 'scene' : btn===btnStyle ? 'style' : btn===btnAbout ? 'about' : currentView || 'dashboard');
}

function getOrbitButtonByView(view){
  const buttonByView = {
    dashboard: btnHome,
    directory: btnDirectory,
    profile: btnMyProfile,
    pet: btnPet,
    legacy: btnLegacy,
    gossip: btnGossip,
    dm: btnDM,
    meet: btnMeet,
    nova: btnNova,
    scene: btnScene,
    style: btnStyle,
    about: btnAbout
  };
  return buttonByView[view] || btnHome;
}

function orbitViewMeta(view){
  const map = {
    dashboard: { labelKey:'home', hintKey:'orbitHintDashboard', descKey:'orbitDescDashboard', icon:'🏠' },
    directory: { labelKey:'students', hintKey:'orbitHintDirectory', descKey:'orbitDescDirectory', icon:'🎓' },
    profile: { labelKey:'myProfile', hintKey:'orbitHintProfile', descKey:'orbitDescProfile', icon:'👤' },
    pet: { labelKey:'pet', hintKey:'orbitHintPet', descKey:'orbitDescPet', icon:'🐣' },
    legacy: { labelKey:'legacy', hintKey:'orbitHintLegacy', descKey:'orbitDescLegacy', icon:'💬' },
    gossip: { labelKey:'gossipTitle', hintKey:'orbitHintGossip', descKey:'orbitDescGossip', icon:'🔥' },
    dm: { labelKey:'dm', hintKey:'orbitHintDm', descKey:'orbitDescDm', icon:'✉️' },
    meet: { labelKey:'meet', hintKey:'orbitHintMeet', descKey:'orbitDescMeet', icon:'🪐' },
    nova: { labelKey:'novaTitle', hintKey:'orbitHintNova', descKey:'orbitDescNova', icon:'⚡' },
    scene: { labelKey:'sceneNav', hintKey:'orbitHintScene', descKey:'orbitDescScene', icon:'🎬' },
    style: { labelKey:'styleNav', hintKey:'orbitHintStyle', descKey:'orbitDescStyle', icon:'✨' },
    about: { labelKey:'about', hintKey:'orbitHintAbout', descKey:'orbitDescAbout', icon:'🧭' }
  };
  const item = map[view] || map.dashboard;
  return {
    label: t(item.labelKey),
    hint: t(item.hintKey),
    icon: item.icon,
    desc: t(item.descKey || '')
  };
}

function syncOrbitCardDescriptions(){
  getOrbitButtons().forEach(btn=>{
    const meta = orbitViewMeta(orbitButtonToView(btn));
    const desc = btn.querySelector('.orbitItemDesc');
    if(desc) desc.textContent = meta?.desc || '';
  });
}

function triggerPageZoom(){
  if(!document.body) return;
  document.body.classList.remove('page-zooming');
  void document.body.offsetWidth;
  document.body.classList.add('page-zooming');
  clearTimeout(orbitNavigateTimer);
  orbitNavigateTimer = setTimeout(()=>document.body?.classList.remove('page-zooming'), 420);
}

function setOrbitTheme(view){
  const target = view || 'dashboard';
  if(drawer) drawer.dataset.view = target;
  document.body.dataset.orbitView = target;
}

function setOrbitInfo(meta){
  const safeMeta = meta || orbitViewMeta(currentView || 'dashboard');
  if(orbitActiveName) orbitActiveName.textContent = safeMeta?.label || 'MEra';
  if(orbitActiveHint) orbitActiveHint.textContent = safeMeta?.hint || t('orbitCoreDefaultHint');
  if(orbitSelectedEmoji) orbitSelectedEmoji.textContent = safeMeta?.icon || '🪐';
  if(orbitSelectedTitle) orbitSelectedTitle.textContent = safeMeta?.label || 'MEra';
  if(orbitSelectedHint) orbitSelectedHint.textContent = safeMeta?.hint || t('orbitCoreDefaultHint');
  if(orbitGoBtn) orbitGoBtn.textContent = t('orbitGo');
}

function normalizeOrbitRotation(){
  while(orbitRotation > 360) orbitRotation -= 360;
  while(orbitRotation < -360) orbitRotation += 360;
}

function getOrbitPointerAngle(clientX, clientY){
  if(!orbitStage) return 0;
  const rect = orbitStage.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;
  return Math.atan2(clientY - centerY, clientX - centerX) * 180 / Math.PI;
}

function stopOrbitMomentum(){
  if(orbitMomentumFrame){
    cancelAnimationFrame(orbitMomentumFrame);
    orbitMomentumFrame = null;
  }
}

function snapOrbitToNearest(preferredBtn = null){
  const buttons = getOrbitButtons();
  if(!buttons.length) return;
  let bestBtn = preferredBtn;
  if(!bestBtn){
    let bestWeight = -Infinity;
    buttons.forEach((btn)=>{
      const base = Number(btn.dataset.orbitAngle || 0);
      const angle = (base + orbitRotation) * (Math.PI / 180);
      const x = Math.cos(angle);
      const y = Math.sin(angle);
      const weight = y - Math.abs(x) * 0.18;
      if(weight > bestWeight){
        bestWeight = weight;
        bestBtn = btn;
      }
    });
  }
  if(!bestBtn) return;
  const targetAngle = Number(bestBtn.dataset.orbitAngle || 0);
  orbitRotation = 90 - targetAngle;
  normalizeOrbitRotation();
  renderOrbitMenu(bestBtn.id);
}

function runOrbitMomentum(){
  stopOrbitMomentum();
  snapOrbitToNearest();
}

function maybeShowOrbitTutorial(){
  if(!orbitTutorial) return;
  if(localStorage.getItem(ORBIT_TUTORIAL_KEY)) return;
  orbitTutorial.classList.remove('hidden');
  requestAnimationFrame(()=>orbitTutorial.classList.add('is-visible'));
  localStorage.setItem(ORBIT_TUTORIAL_KEY, '1');
}

function dismissOrbitTutorial(){
  if(!orbitTutorial) return;
  orbitTutorial.classList.remove('is-visible');
  setTimeout(()=>orbitTutorial.classList.add('hidden'), 260);
}

function renderOrbitMenu(forceActiveId = null){
  if(!orbitStage) return;
  const buttons = getOrbitButtons();
  const radius = window.innerWidth <= 640 ? 138 : 184;
  let bestBtn = null;
  let bestWeight = -Infinity;
  buttons.forEach((btn)=>{
    const base = Number(btn.dataset.orbitAngle || 0);
    const angle = (base + orbitRotation) * (Math.PI / 180);
    const x = Math.cos(angle) * radius;
    const y = Math.sin(angle) * radius;
    const depth = (Math.sin(angle) + 1) / 2;
    const forcedActive = !!forceActiveId && btn.id === forceActiveId;
    btn.style.setProperty('--orbit-x', `${x.toFixed(1)}px`);
    btn.style.setProperty('--orbit-y', `${y.toFixed(1)}px`);
    btn.style.setProperty('--orbit-scale', (0.82 + depth * 0.34 + (forcedActive ? 0.05 : 0)).toFixed(3));
    btn.style.setProperty('--orbit-opacity', (0.34 + depth * 0.66).toFixed(3));
    btn.style.setProperty('--orbit-z', String(10 + Math.round(depth * 48) + (forcedActive ? 5 : 0)));
    btn.classList.toggle('is-back', depth < 0.42);
    const weight = y - Math.abs(x) * 0.18 + (forcedActive ? 100 : 0);
    if(weight > bestWeight){
      bestWeight = weight;
      bestBtn = btn;
    }
  });
  buttons.forEach(btn=>{
    const isActive = btn===bestBtn;
    btn.classList.toggle('is-active', isActive);
    btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
  });
  syncOrbitCardDescriptions();
  if(bestBtn){
    orbitSelectedId = bestBtn.id;
    const selectedView = orbitButtonToView(bestBtn);
    setOrbitTheme(selectedView);
    setOrbitInfo(orbitViewMeta(selectedView));
  }
}

function syncOrbitToView(view){
  const target = getOrbitButtonByView(view);
  getOrbitButtons().forEach(btn=>btn.classList.toggle('is-current-view', btn===target));
  setOrbitTheme(view);
  setOrbitInfo(orbitViewMeta(view));
  if(target){
    const targetAngle = Number(target.dataset.orbitAngle || 0);
    orbitRotation = 90 - targetAngle;
    renderOrbitMenu(target.id);
  } else {
    renderOrbitMenu();
  }
}

function cycleOrbit(step){
  const buttons = getOrbitButtons();
  if(!buttons.length) return;
  const currentIndex = Math.max(0, buttons.findIndex(btn=>btn.id === orbitSelectedId));
  const nextIndex = (currentIndex + step + buttons.length) % buttons.length;
  snapOrbitToNearest(buttons[nextIndex]);
}

function orbitNavigateViaButton(btn){
  if(!btn) return;
  orbitDirectNavigateId = btn.id;
  triggerPageZoom();
  setTimeout(()=>btn.click(), 120);
}

function orbitGoToSelection(){
  orbitNavigateViaButton(getOrbitButtons().find(btn=>btn.id === orbitSelectedId) || getOrbitButtonByView(currentView));
}

function shouldOrbitSelect(btn){
  return false;
}

const SIMPLE_MENU_VIEWS = new Set(["dashboard","directory","profile","pet","legacy","gossip","dm","meet","nova","scene","style","blast","about"]);

function setMenuBusy(view, busy){
  document.querySelectorAll(".simpleMenuItem[data-view]").forEach(btn=>{
    const isTarget = (btn.dataset.view || "") === view;
    btn.classList.toggle("is-loading", !!busy && isTarget);
    btn.disabled = !!busy && isTarget;
    btn.setAttribute("aria-busy", (!!busy && isTarget) ? "true" : "false");
  });
}

async function navigateSimpleMenu(view, options = {}){
  const target = SIMPLE_MENU_VIEWS.has(view) ? view : "dashboard";
  const previousView = currentView || "dashboard";
  const shouldPush = options.push !== false && target !== previousView;
  closeDrawer();
  highlightSimpleMenu(target);
  setMenuBusy(target, true);

  // Geçişi önce yap: API/veri yükleme hatası olsa bile kullanıcı bastığı sekmeyi görür.
  if(shouldPush) pushNavState({type:"view", view: previousView});
  switchView(target);

  try{
    if(target === "dashboard"){ if(me && typeof loadDashboard === "function") await loadDashboard(); return; }
    if(target === "directory"){ if(typeof loadUsers === "function") await loadUsers(); return; }
    if(target === "profile"){ if(me && typeof selectUser === "function") await selectUser(me.id); return; }
    if(target === "pet"){ if(typeof loadPets === "function") await loadPets(); return; }
    if(target === "legacy"){ setMsg(legacyMsg,""); if(typeof loadLegacy === "function") await loadLegacy(); return; }
    if(target === "gossip"){ setMsg(gossipMsg,""); if(typeof loadGossip === "function") await loadGossip(); return; }
    if(target === "dm"){ setMsg(dmMsg,""); if(typeof loadDM === "function") await loadDM(); return; }
    if(target === "meet"){ if(typeof loadMeetups === "function") await loadMeetups(); return; }
    if(target === "nova"){ if(typeof loadNovaCurrentTab === "function") await loadNovaCurrentTab(); return; }
    if(target === "scene"){ if(typeof loadScene === "function") await loadScene(); return; }
    if(target === "style"){ if(typeof loadStyle === "function") await loadStyle(); return; }
    if(target === "blast"){ if(typeof loadBlast === "function") await loadBlast(); return; }
    if(target === "about"){ return; }
  }catch(e){
    const msg = e?.message || "Menü geçişinde veri yükleme hatası oluştu.";
    if(target === "dm") setMsg(dmMsg, msg);
    else if(target === "pet") setMsg($("petMsg"), msg);
    else if(target === "legacy") setMsg(legacyMsg, msg);
    else if(target === "gossip") setMsg(gossipMsg, msg);
    else if(target === "meet") setMsg($("meetMsg"), msg);
    else if(target === "scene") setMsg($("sceneMsg"), msg);
    else if(target === "style") setMsg($("styleMsg"), msg);
    else if(target === "blast") setMsg(blastMsg, msg);
    else setMsg(appMsg, msg);
  }finally{
    setMenuBusy(target, false);
    highlightSimpleMenu(currentView || target);
  }
}

function bindSimpleMenuNavigation(){
  document.querySelectorAll('.simpleMenuItem[data-view]').forEach((btn)=>{
    if(btn.dataset.navBound === '1') return;
    btn.dataset.navBound = '1';
    btn.addEventListener('click', (e)=>{
      e.preventDefault();
      e.stopPropagation();
      if(typeof e.stopImmediatePropagation === 'function') e.stopImmediatePropagation();
      navigateSimpleMenu(btn.dataset.view || 'dashboard');
    });
    btn.addEventListener('keydown', (e)=>{
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        navigateSimpleMenu(btn.dataset.view || 'dashboard');
      }
    });
  });
}
function bindOrbitInteractions(){
  if(!orbitStage || orbitStage.dataset.bound === '1') return;
  orbitStage.dataset.bound = '1';

  orbitPrevBtn?.addEventListener('click', ()=>cycleOrbit(-1));
  orbitNextBtn?.addEventListener('click', ()=>cycleOrbit(1));
  orbitGoBtn?.addEventListener('click', (e)=>{
    e.stopPropagation();
    orbitGoToSelection();
  });
  orbitCenterCore?.addEventListener('click', (e)=>{
    if(e.target === orbitGoBtn) return;
    orbitGoToSelection();
  });
  orbitCenterCore?.addEventListener('keydown', (e)=>{
    if(e.key === 'Enter' || e.key === ' '){
      e.preventDefault();
      orbitGoToSelection();
    }
  });
  orbitTutorialDismiss?.addEventListener('click', dismissOrbitTutorial);
  orbitTutorial?.addEventListener('click', (e)=>{ if(e.target === orbitTutorial) dismissOrbitTutorial(); });
  document.querySelectorAll('[data-orbit-jump]').forEach((btn)=>{
    btn.addEventListener('click', ()=>{
      orbitNavigateViaButton(getOrbitButtonByView(btn.getAttribute('data-orbit-jump')));
    });
  });
  getOrbitButtons().forEach((btn)=>{
    btn.addEventListener('mouseenter', ()=>setOrbitInfo(orbitViewMeta(orbitButtonToView(btn))));
    btn.addEventListener('focus', ()=>setOrbitInfo(orbitViewMeta(orbitButtonToView(btn))));
    btn.addEventListener('mouseleave', ()=>setOrbitInfo(orbitViewMeta(orbitButtonToView(getOrbitButtons().find(item=>item.id === orbitSelectedId) || getOrbitButtonByView(currentView)))));
    btn.addEventListener('blur', ()=>setOrbitInfo(orbitViewMeta(orbitButtonToView(getOrbitButtons().find(item=>item.id === orbitSelectedId) || getOrbitButtonByView(currentView)))));
  });
  orbitStage.addEventListener('pointermove', (e)=>{
    const active = getOrbitButtons().find(item=>item.id === orbitSelectedId);
    if(!active) return;
    const rect = active.getBoundingClientRect();
    const px = ((e.clientX - rect.left) / Math.max(rect.width,1)) - .5;
    const py = ((e.clientY - rect.top) / Math.max(rect.height,1)) - .5;
    active.style.setProperty('--orbit-px', `${(px * 8).toFixed(2)}px`);
    active.style.setProperty('--orbit-py', `${(py * 6).toFixed(2)}px`);
    active.style.setProperty('--orbit-rx', `${(-py * 5).toFixed(2)}deg`);
    active.style.setProperty('--orbit-ry', `${(px * 7).toFixed(2)}deg`);
  });
  orbitStage.addEventListener('pointerleave', ()=>{
    const active = getOrbitButtons().find(item=>item.id === orbitSelectedId);
    if(!active) return;
    ['--orbit-px','--orbit-py','--orbit-rx','--orbit-ry'].forEach(key=>active.style.removeProperty(key));
  });
  orbitStage.addEventListener('wheel', (e)=>{
    e.preventDefault();
    cycleOrbit(e.deltaY > 0 ? 1 : -1);
  }, { passive:false });
  window.addEventListener('resize', ()=>renderOrbitMenu(orbitSelectedId));
  document.addEventListener('keydown', (e)=>{
    if(drawer?.classList.contains('hidden')) return;
    if(e.key === 'Escape') closeDrawer();
    if(e.key === 'ArrowLeft'){ e.preventDefault(); cycleOrbit(-1); }
    if(e.key === 'ArrowRight'){ e.preventDefault(); cycleOrbit(1); }
  });
}


function escapeHtml(s){
  return String(s ?? "").replace(/[&<>"']/g, c=>({ "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;" }[c]));
}

function resolveUrl(u){
  const s = String(u ?? "").trim();
  if(!s) return "";
  try{ return new URL(s, window.location.href).toString(); }catch(_){ return s; }
}

function avatarHtml(u){
  if(u && u.photo_url){
    return `<div class="avatar"><img src="${escapeHtml(resolveUrl(u.photo_url))}" alt="pp"></div>`;
  }
  const initials = (u?.full_name || "?").trim().split(/\s+/).slice(0,2).map(x=>x[0]?.toUpperCase()).join("");
  return `<div class="avatar">${escapeHtml(initials || "?")}</div>`;
}

async function api(action, method="GET", body=null, isForm=false){
  const qs = (method==="GET" && body && !isForm) ? ("&" + new URLSearchParams(body).toString()) : "";
  const cacheBust = method === "GET" ? `&_=${Date.now()}` : "";
  const url = `${API}?action=${encodeURIComponent(action)}${qs}${cacheBust}`;
  const headers = {};
  const token = getToken();
  if(token) headers["Authorization"] = `Bearer ${token}`;
  const opt = { method, headers, cache:"no-store" };
  if(method !== "GET" && body){
    if(isForm){
      opt.body = body;
    }else{
      headers["Content-Type"] = "application/json";
      opt.body = JSON.stringify(body);
    }
  }
  const res = await fetch(url, opt);
  const text = await res.text();
  let data = null;
  try{ data = JSON.parse(text); }catch(_){
    throw new Error("Sunucudan JSON gelmedi. İlk 200 karakter: " + text.slice(0,200));
  }
  if(!data.ok) throw new Error(data.debug?.message ? `${data.error || 'Hata'}: ${data.debug.message}` : (data.error || 'Hata'));
  return data;
}


function ensureNotificationTray(){
  let el = document.getElementById('appNotificationTray');
  if(!el){
    el = document.createElement('div');
    el.id = 'appNotificationTray';
    el.className = 'appNotificationTray';
    document.body.appendChild(el);
  }
  return el;
}
function showAppNotice(title, body, actions=''){
  const tray = ensureNotificationTray();
  const box = document.createElement('div');
  box.className = 'appNotice';
  box.innerHTML = `<div><b>${escapeHtml(title||'Bilgilendirme')}</b><p>${escapeHtml(body||'')}</p>${actions}</div><button class="btn tiny" data-close-notice>×</button>`;
  box.querySelector('[data-close-notice]').onclick = ()=> box.remove();
  tray.prepend(box);
  setTimeout(()=>{ if(box.isConnected) box.classList.add('softOut'); }, 14000);
  setTimeout(()=>{ if(box.isConnected) box.remove(); }, 18000);
  return box;
}
function firstWelcomeKey(user = me){
  const id = user?.id || user?.email || 'guest';
  return FIRST_WELCOME_PREFIX + String(id);
}

function maybeShowFirstWelcome(user = me){
  if(!user) return;
  const key = firstWelcomeKey(user);
  if(localStorage.getItem(key)) return;
  localStorage.setItem(key, '1');
  const firstName = (user.full_name || '').split(' ')[0] || 'MEra';
  const title = lang === 'en' ? `Welcome, ${firstName}!` : `Hoş geldin, ${firstName}!`;
  const body = lang === 'en'
    ? 'We are glad you decided to create your own era. Start by shaping your profile, scene and style.'
    : 'Kendi çağını yaratmaya karar vermen bizi sevindirdi. Profilini, Scene ruhunu ve Style akışını şekillendirerek başlayabilirsin.';
  const actions = `<button class="btn tiny primary" data-first-welcome-profile>${escapeHtml(lang === 'en' ? 'Create my era' : 'Çağımı başlat')}</button>`;
  const box = showAppNotice(title, body, actions);
  box.classList.add('welcomeNotice');
  const btn = box.querySelector('[data-first-welcome-profile]');
  if(btn) btn.onclick = ()=>{ box.remove(); navigateSimpleMenu('profile'); };
}

async function loadAppNotifications(){
  if(!getToken()) return;
  try{
    const d = await api('my_notifications');
    const sidebarDmEnabled = Number(me?.dm_sidebar_alerts_enabled ?? 1) === 1;
    const unread = (d.items||[]).filter(x=>!Number(x.is_read) && (sidebarDmEnabled || !String(x.type||"").startsWith("dm"))).slice(0,3);
    unread.forEach(n=>{
      const box = showAppNotice(n.title, n.body, `<button class="btn tiny" data-read-notice="${n.id}">Okudum</button>`);
      const btn = box.querySelector('[data-read-notice]');
      if(btn) btn.onclick = async()=>{ try{ await api('notifications_read','POST',{id:Number(btn.dataset.readNotice)}); }catch(_){} box.remove(); };
    });
  }catch(_){ }
}
async function checkReportReminders(){
  if(!getToken()) return;
  try{
    const d = await api('report_reminders');
    (d.reminders||[]).forEach(r=>{
      const box = showAppNotice('Şikayet hatırlatması', r.message, `<button class="btn tiny primary" data-edit-report="${r.id}">Şikayetlerime Git</button>`);
      const btn = box.querySelector('[data-edit-report]');
      if(btn) btn.onclick = ()=>{ box.remove(); switchView('profile'); setTimeout(()=>loadMyReports?.(),200); };
    });
  }catch(_){ }
}

function setSceneMode(mode){
  document.body.classList.toggle("auth-mode", mode === "auth");
  document.body.classList.toggle("app-mode", mode === "app");
}

function showAuth(){
  setSceneMode("auth");
  topbar.classList.add("hidden");
  authView.classList.remove("hidden");
  appView.classList.add("hidden");
}
function showApp(){
  setSceneMode("app");
  topbar.classList.remove("hidden");
  authView.classList.add("hidden");
  appView.classList.remove("hidden");
}

function setMe(u){
  me = u || null;
  if(!me){ showAuth(); return; }
  showApp();
  meBadge.classList.remove("hidden");

  if(btnAdmin){ if(u && u.is_admin) btnAdmin.classList.remove('hidden'); else btnAdmin.classList.add('hidden'); }
  if(btnAdminPortal){ btnAdminPortal.classList.toggle('hidden', !(u && Number(u.is_admin)===1)); }
  updateAdminCountdownPill();
  meBadge.textContent = `👤 `;
  meBadge.title = lang === "en" ? "Go to my profile" : "Profilime git";
  meBadge.setAttribute("aria-label", meBadge.title);
}

async function openMyProfileFromTopbar(){
  if(!me || !me.id) return;
  try{
    meBadge.classList.add("is-loading");
    await navigateSimpleMenu("profile", { push: true });
  }catch(e){
    setMsg(appMsg, e?.message || (lang === "en" ? "Profile could not be opened." : "Profil açılamadı."));
  }finally{
    meBadge.classList.remove("is-loading");
  }
}

function fillYearFilter(){
  const now = new Date().getFullYear();
  filterYear.innerHTML = `<option value="">Mezuniyet (hepsi)</option>`;
  for(let y=now; y>=1995; y--){
    const opt=document.createElement("option");
    opt.value=String(y);
    opt.textContent=String(y);
    filterYear.appendChild(opt);
  }
}

function animateInElements(elements){
  (elements||[]).filter(Boolean).forEach((el, idx)=>{
    el.classList.remove("view-enter");
    el.style.setProperty("--stagger", `${idx * 70}ms`);
    void el.offsetWidth;
    el.classList.add("view-enter");
  });
}

function animateHomeEntrance(el){
  if(!el) return;
  document.body.classList.add("homeEntranceActive");
  el.classList.remove("home-entrance");
  void el.offsetWidth;
  el.classList.add("home-entrance");
  setTimeout(()=>document.body.classList.remove("homeEntranceActive"), 1250);
}

function pushNavState(state){
  if(suppressNavPush || !state) return;
  const last = navStack.length ? navStack[navStack.length-1] : null;
  if(last && JSON.stringify(last) === JSON.stringify(state)) return;
  navStack.push(state);
  if(navStack.length > 40) navStack.shift();
}

async function goBack(fallback = "directory") {
  const prev = navStack.pop();
  if(!prev){
    switchView(fallback);
    return;
  }
  if(prev.type === "profile" && prev.userId){
    suppressNavPush = true;
    try{ await selectUser(Number(prev.userId)); }
    finally{ suppressNavPush = false; }
    return;
  }
  switchView(prev.view || fallback);
}

function switchView(v){
  if(v !== "dm" && !dmCallState) stopDmCallSignalPolling();
  if(v === "dm") startDmCallSignalPolling();
  highlightSimpleMenu(v);
  currentView = v;
  syncOrbitToView(v);
  if(appView) appView.dataset.view = v;
  const novaCard = $("novaCard");
  if(dashboardCard) dashboardCard.classList.toggle("hidden", v!=="dashboard");
  directoryCard.classList.toggle("hidden", v!=="directory");
  profileCard.classList.toggle("hidden", true);
  profilePage.classList.toggle("hidden", v!=="profile");
  if(petCard) petCard.classList.toggle("hidden", v!=="pet");
  legacyCard.classList.toggle("hidden", v!=="legacy");
  gossipCard.classList.toggle("hidden", v!=="gossip");
  dmCard.classList.toggle("hidden", v!=="dm");
  if(meetCard) meetCard.classList.toggle("hidden", v!=="meet");
  if(novaCard) novaCard.classList.toggle("hidden", v!=="nova");
  if(sceneCard) sceneCard.classList.toggle("hidden", v!=="scene");
  if(styleCard) styleCard.classList.toggle("hidden", v!=="style");
  if(blastCard) blastCard.classList.toggle("hidden", v!=="blast");
  if(psyCard) psyCard.classList.add("hidden");
  if(aboutCard) aboutCard.classList.toggle("hidden", v!=="about");
  if(adminCard) adminCard.classList.add('hidden');
  setMsg(appMsg, "");
  const entering = [];
  if(v === "dashboard" && dashboardCard) entering.push(dashboardCard);
  if(v === "directory") entering.push(directoryCard);
  if(v === "profile") entering.push(profilePage);
  if(v === "pet" && petCard) entering.push(petCard);
  if(v === "legacy") entering.push(legacyCard);
  if(v === "gossip") entering.push(gossipCard);
  if(v === "dm") entering.push(dmCard);
  if(v === "meet" && meetCard) entering.push(meetCard);
  if(v === "nova" && novaCard) entering.push(novaCard);
  if(v === "scene" && sceneCard) entering.push(sceneCard);
  if(v === "style" && styleCard) entering.push(styleCard);
  if(v === "blast" && blastCard) entering.push(blastCard);
  if(v === "about") entering.push(aboutCard);
  if(v === "dashboard" && homeEntrancePending){
    homeEntrancePending = false;
    animateHomeEntrance(dashboardCard);
  }
  if(v === "about") activateAboutExperience(); else stopAboutExperience();
  try{ window.scrollTo({top:0, behavior:'smooth'}); }catch(_){ window.scrollTo(0,0); }
}

function setTab(which){
  activeTab = which;
  tabProfile.classList.toggle("active", which==="profile");
  tabInbox.classList.toggle("active", which==="inbox");
  tabFarewells.classList.toggle("active", which==="farewells");
  tabSent.classList.toggle("active", which==="sent");

  panelProfile.classList.toggle("hidden", which!=="profile");
  panelInbox.classList.toggle("hidden", which!=="inbox");
  panelFarewells.classList.toggle("hidden", which!=="farewells");
  panelSent.classList.toggle("hidden", which!=="sent");
  const activePanel = which === "profile" ? panelProfile : which === "inbox" ? panelInbox : which === "farewells" ? panelFarewells : panelSent;
  animateInElements([activePanel]);
}

function renderUserList(users){
  userList.innerHTML = "";
  (users||[]).filter(u=>!me || Number(u.id)!==Number(me.id)).forEach(u=>{
    const card=document.createElement("div");
    card.className="userCard userCardWithActions";
    card.innerHTML = `${avatarHtml(u)}<div class="userMeta">
      <div class="userName">${escapeHtml(u.full_name)}</div>
      <div class="userSub muted">${escapeHtml(u.school || "—")} • ${u.grad_year || "—"}</div>
      <div class="userMiniActions">
        <button class="btn tiny" data-open-user="${u.id}">Profili Aç</button>
        ${(Number(u.is_admin||0)===1 || String(u.email||"").toLowerCase()==="admin@mera.com") ? `<span class="pill good">Admin</span>` : `<button class="btn tiny" data-report-user="${u.id}" data-name="${escapeHtml(u.full_name||"")}">Şikayet Et</button><button class="btn tiny" data-block-user="${u.id}" data-name="${escapeHtml(u.full_name||"")}">Engelle</button>`}
      </div>
    </div>`;
    card.querySelector('[data-open-user]').onclick = (e)=>{ e.stopPropagation(); selectUser(u.id); };
    const __reportUserBtn = card.querySelector('[data-report-user]');
    if(__reportUserBtn) __reportUserBtn.onclick = async (e)=>{ e.stopPropagation(); await reportUser(u.id, u.full_name || ''); };
    const __blockUserBtn = card.querySelector('[data-block-user]');
    if(__blockUserBtn) __blockUserBtn.onclick = async (e)=>{ e.stopPropagation(); await blockUser(u.id, u.full_name || ''); };
    card.onclick = ()=>selectUser(u.id);
    userList.appendChild(card);
  });
  if((users||[]).length===0){
    userList.innerHTML = `<p class="muted">Sonuç yok.</p>`;
  }
}

async function reportUser(userId, userName=""){
  if(Number(userId) && selectedUser && Number(selectedUser.id)===Number(userId) && (Number(selectedUser.is_admin||0)===1 || String(selectedUser.email||"").toLowerCase()==="admin@mera.com")){
    setMsg(appMsg, "Admin hesabı şikayet edilemez.");
    return;
  }
  const reason = window.prompt(`${userName ? userName + " için " : ""}şikayet sebebini yaz:`);
  if(reason === null) return;
  const txt = String(reason||"").trim();
  if(!txt){ setMsg(appMsg, "Şikayet sebebi boş olamaz."); return; }
  try{
    const d = await api("report_create","POST",{target_type:"user", target_id:Number(userId), reported_user_id:Number(userId), reason:txt});
    const until = d.report?.editable_until ? ` Son düzenleme: ${d.report.editable_until}` : "";
    setMsg(appMsg, `✅ ${d.message || "Şikayet edildi."}${until}`);
    showAppNotice('Şikayet edildi', 'Şikayetiniz admin paneline gönderildi. 3 gün içinde Profilim > Şikayetlerim bölümünden düzenleyebilir veya silebilirsiniz.');
    if(typeof loadMyReports === "function") await loadMyReports();
  }catch(e){ setMsg(appMsg, e.message || "Şikayet gönderilemedi."); }
}

async function blockUser(userId, userName=""){
  if(Number(userId) && selectedUser && Number(selectedUser.id)===Number(userId) && (Number(selectedUser.is_admin||0)===1 || String(selectedUser.email||"").toLowerCase()==="admin@mera.com")){
    setMsg(appMsg, "Admin hesabı engellenemez.");
    return;
  }
  const ok = window.confirm(`${userName || "Bu kullanıcı"} engellensin mi? Bu kişi sana mesaj atamaz; istediğin zaman Profilimden engeli kaldırabilirsin.`);
  if(!ok) return;
  try{
    await api("block_toggle","POST",{user_id:Number(userId), block:1});
    setMsg(appMsg, "✅ Kullanıcı engellendi.");
    if(typeof loadBlockedUsers === "function") await loadBlockedUsers();
  }catch(e){ setMsg(appMsg, e.message || "Engelleme yapılamadı."); }
}

async function loadBlockedUsers(){
  const list = $("blockedUsersList");
  if(!list) return;
  try{
    const d = await api("my_blocks");
    const items = d.items || [];
    if(!items.length){ list.innerHTML = `<span class="muted small">Engellediğin kişi yok.</span>`; return; }
    list.innerHTML = items.map(u=>`<div class="blockedUserRow"><span>${avatarHtml(u)} <b>${escapeHtml(u.full_name||"")}</b></span><button class="btn tiny" data-unblock="${u.id}">Engeli Kaldır</button></div>`).join("");
    list.querySelectorAll('[data-unblock]').forEach(btn=>btn.onclick = async ()=>{
      await api("block_toggle","POST",{user_id:Number(btn.dataset.unblock), block:0});
      await loadBlockedUsers();
    });
  }catch(e){ list.innerHTML = `<span class="muted small">${escapeHtml(e.message||"Engeller yüklenemedi.")}</span>`; }
}


async function loadMyReports(){
  const list = document.getElementById('myReportsList');
  if(!list) return;
  try{
    const d = await api('my_reports');
    const items = d.reports || [];
    if(!items.length){ list.innerHTML = `<span class="muted small">Henüz şikayetin yok.</span>`; return; }
    list.innerHTML = items.map(r=>{
      const status = r.status === 'closed' ? 'Çözüldü' : 'Açık';
      const edit = r.can_edit ? `<button class="btn tiny" data-edit-my-report="${r.id}">Düzenle</button><button class="btn tiny danger" data-delete-my-report="${r.id}">Sil</button>` : `<span class="muted small">Düzenleme süresi doldu</span>`;
      const note = r.resolution_note ? `<div class="small muted">Admin notu: ${escapeHtml(r.resolution_note)}</div>` : '';
      return `<div class="myReportRow"><div><b>#${r.id} ${escapeHtml(r.reported_name || r.target_type)}</b><div class="small muted">${status} • Son düzenleme: ${escapeHtml(r.editable_until||'-')}</div><p>${escapeHtml(r.reason||'')}</p>${note}</div><div class="profileInlineActions">${edit}</div></div>`;
    }).join('');
    list.querySelectorAll('[data-edit-my-report]').forEach(btn=>btn.onclick=async()=>{
      const id = Number(btn.dataset.editMyReport);
      const item = items.find(x=>Number(x.id)===id);
      const next = window.prompt('Şikayet sebebini güncelle:', item?.reason || '');
      if(next === null) return;
      await api('report_update','POST',{id, reason:String(next).trim()});
      await loadMyReports();
      showAppNotice('Şikayet güncellendi','Şikayet metniniz başarıyla güncellendi.');
    });
    list.querySelectorAll('[data-delete-my-report]').forEach(btn=>btn.onclick=async()=>{
      const id = Number(btn.dataset.deleteMyReport);
      if(!window.confirm('Bu şikayeti silmek istediğine emin misin?')) return;
      await api('report_delete','POST',{id});
      await loadMyReports();
      showAppNotice('Şikayet silindi','Şikayetiniz kaldırıldı.');
    });
  }catch(e){ list.innerHTML = `<span class="muted small">${escapeHtml(e.message||'Şikayetler yüklenemedi.')}</span>`; }
}



function petEmoji(p){
  const st = p?.state || {};
  if(st.mood === 'crying') return '😭';
  if(st.mood === 'sad') return '🥺';
  if(st.mood === 'sleepy') return '😴';
  if(st.mood === 'uncomfortable') return '😵‍💫';
  if(st.mood === 'sensitive') return '🐥🩹';
  const eggs = Number(p?.egg_count || 0);
  const stage = Number(st.stage || 1);
  if(stage >= 5) return eggs > 0 ? '🐔🥚' : '🐔';
  if(stage === 4) return '🐓';
  if(stage === 3) return '🐔';
  if(stage === 2) return '🐥';
  return '🐣';
}
function petStageName(p){
  const stage = Number(p?.state?.stage || 1);
  return ['','Yeni civciv','Büyüyen civciv','Genç tavuk','Yetişkin tavuk','Yumurtalı çiftlik'][Math.max(1, Math.min(5, stage))] || 'Civciv';
}
function petMoodText(p){
  const m = p?.state?.mood || 'happy';
  return {happy:'Mutlu', crying:'Ağlıyor / aç', sad:'Üzgün', sleepy:'Uykulu', uncomfortable:'Rahatsız', sensitive:'Hassas / özel bakım'}[m] || 'Mutlu';
}

function petAgeText(p){
  const age = p?.state?.age || {};
  return age.age_text || `${p?.state?.age_days||0} günlük`;
}
function petAgeLabel(p){
  const stage = Number(p?.state?.stage || 1);
  return stage >= 3 ? `Tavuk yaşı: ${petAgeText(p)}` : `Civciv yaşı: ${petAgeText(p)}`;
}
function petFarmStatsHtml(pets){
  const own = (pets||[]).filter(p=>Number(p.owner_id)===Number(me?.id) && ['solo','chick'].includes(p.pet_type));
  const chicks = own.filter(p=>Number(p?.state?.stage||1) < 3).length;
  const chickens = own.filter(p=>Number(p?.state?.stage||1) >= 3).length;
  const eggs = own.reduce((a,p)=>a+Number(p.egg_count||0),0);
  const special = own.filter(p=>(p.health_status||'healthy') !== 'healthy').length;
  const oldest = own.slice().sort((a,b)=>Number(b?.state?.age_days||0)-Number(a?.state?.age_days||0))[0];
  return `<div class="petFarmStats">
    <div><b>${own.length}</b><span>Toplam canlı</span></div>
    <div><b>${chicks}</b><span>Civciv</span></div>
    <div><b>${chickens}</b><span>Tavuk</span></div>
    <div><b>${eggs}</b><span>Yumurta</span></div>
    <div><b>${special}</b><span>Özel bakım</span></div>
    <div><b>${oldest?escapeHtml(petAgeText(oldest)):'-'}</b><span>En büyük yaş</span></div>
  </div>`;
}
function updatePetSidePanel(pets){
  const box = $('petFarmStatsBox');
  if(box) box.innerHTML = petFarmStatsHtml(pets||[]);
  const hint = $('petAgeClockHint');
  if(hint) hint.textContent = 'Avatar takvimi: 1 gerçek saat = 1 avatar günü. Açlık ve mutluluk daha hızlı değişir; düzenli bakım çiftliği canlı tutar.';
}
function petCareMessage(p){
  const st = p?.state || {};
  const name = escapeHtml(p?.name || 'Avatarın');
  if((p?.health_status||'healthy') !== 'healthy') return `${name}: Bugün biraz hassasım. Beni yavaşça sev, iyi gelecektir 🩹`;
  if(st.hunger >= 80) return `${name}: Açım, beni besler misin? 🍽️`;
  if(st.energy_need >= 80) return `${name}: Biraz uyusam harika olur... 🌙`;
  if(st.toilet >= 80) return `${name}: Tuvalet zamanı geldi gibi 🚽`;
  if(Number(p?.egg_count||0) > 0) return `${name}: Yumurtalarım var, yakında minik yavrularla devam edeceğiz 🥚`;
  if(st.happiness >= 90) return `${name}: Bana çok güzel bakıyorsun, çok mutluyum 💜`;
  return `${name}: Bugün birlikte ne yapalım? ✨`;
}
function petBar(label, value){
  const v = Math.max(0, Math.min(100, Number(value||0)));
  return `<div class="petNeed"><span>${label}</span><b>${v}%</b><div class="petNeedTrack"><i style="width:${v}%"></i></div></div>`;
}
function petActionLabel(act){ return {feed:'Besle',toilet:'Tuvalet',sleep:'Uyut',play:'Sev',pet:'Sev'}[act] || act; }
async function loadPetPartners(){
  const sel = $('petPartnerSelect'); if(sel) sel.innerHTML = `<option value=""></option>`;
}
function petCardHtml(p, {compact=false, active=false}={}){
  const st=p.state||{};
  const visibility = p.visibility || 'public';
  const msgOn = Number(p.messages_enabled ?? 1) === 1;
  const eggCount = Number(p.egg_count || 0);
  const isChild = p.pet_type === 'chick';
  const ownerDelete = Number(p.owner_id) === Number(me?.id) ? `<button class="btn tiny danger" data-pet-delete="${p.id}">Sahiplendir / Sil</button>` : '';
  const adoptBtn = (Number(p.owner_id) === Number(me?.id)) ? `<button class="btn tiny" data-pet-adopt="${p.id}" data-name="${escapeHtml(p.name||'Avatar')}">Sahiplendir</button>` : '';
  const trait = p.trait_label ? `<span class="petBadge">🌟 ${escapeHtml(p.trait_label)}</span>` : '';
  const special = (p.health_status && p.health_status !== 'healthy') ? `<div class="petSpecialCare">🩹 Bu özel civciv hassas. Daha yavaş sev, düzenli besle; birkaç gün içinde iyileşebilir.</div>` : '';
  return `<article class="petBox petSoloBox ${active?'activePet':''} ${isChild?'petChildBox':''} petColor-${escapeHtml(p.color||'violet')}" data-pet-card-id="${p.id}">
    <div class="petStage"><span class="petSpark">✨</span><span class="petFood">🍪</span><span class="petMoon">💤</span><span class="petHeart">💜</span></div>
    <div class="petTop petTopLarge"><button class="petAvatarIcon petAvatarIconBig" data-open-pet-play="${p.id}" title="Sevmek için aç">${petEmoji(p)}</button><div><h3>${escapeHtml(p.name||'Avatar')}</h3><div class="muted small">${petStageName(p)} • ${petMoodText(p)} • ${petAgeLabel(p)} • Nesil ${p.generation||1}</div><div class="petBadges"><span class="petBadge">XP: ${p.xp||0}</span><span class="petBadge">⏱️ ${escapeHtml(petAgeText(p))}</span><span class="petBadge">${visibility==='public'?'Herkes görebilir':'Sadece sen'}</span>${trait}${eggCount?`<span class="petBadge">🥚 ${eggCount} yumurta</span>`:''}</div></div></div>
    <div class="petAgeCard"><b>Yaş sistemi</b><span>${escapeHtml(petAgeText(p))} — ${escapeHtml(st.age?.clock_note || '1 gerçek saat = 1 avatar günü')}</span></div>
    ${special}
    <div class="petSpeech">${msgOn ? petCareMessage(p) : 'Avatar mesajları kapalı 🔕'}</div>
    <div class="petNeeds">${petBar('Açlık', st.hunger)}${petBar('Tuvalet', st.toilet)}${petBar('Uyku ihtiyacı', st.energy_need)}${petBar('Mutluluk', st.happiness)}</div>
    <div class="petCarePad"><button class="petCareButton feed" data-pet-act="feed" data-id="${p.id}">🍽️<span>Besle</span></button><button class="petCareButton toilet" data-pet-act="toilet" data-id="${p.id}">🚽<span>Tuvalet</span></button><button class="petCareButton sleep" data-pet-act="sleep" data-id="${p.id}">🌙<span>Uyut</span></button><button class="petCareButton play" data-open-pet-play="${p.id}">🤲<span>Sev</span></button></div>
    <div class="petSettingsRow"><label><span class="small muted">Görünürlük</span><select class="input" data-pet-visibility><option value="public" ${visibility==='public'?'selected':''}>Herkes görebilir</option><option value="private" ${visibility==='private'?'selected':''}>Sadece ben</option></select></label><label class="checkRow petMsgToggle"><input type="checkbox" data-pet-messages ${msgOn?'checked':''}/> <span>Avatar mesajları açık</span></label><button class="btn tiny" data-pet-settings="${p.id}">Ayarları Kaydet</button></div>
    <div class="petActions"><button class="btn tiny" data-pet-rename="${p.id}" data-name="${escapeHtml(p.name||'')}">İsim Değiştir</button>${adoptBtn}${ownerDelete}</div>
  </article>`;
}
function petSelectorHtml(p, activeId){
  return `<button class="petSwitchBtn ${Number(activeId)===Number(p.id)?'active':''}" data-switch-pet="${p.id}"><span>${petEmoji(p)}</span><b>${escapeHtml(p.name||'Civciv')}</b><small>${petStageName(p)}</small></button>`;
}
function eggPanelHtml(pets, activePet){
  const eggPets = pets.filter(p=>Number(p.egg_count||0)>0 && Number(p.owner_id)===Number(me?.id));
  if(!eggPets.length) return `<div class="petEggPanel"><b>🥚 Yumurtaları kontrol et</b><span class="muted small">Henüz yumurta yok. Civcivin tavuğa dönüşünce kısa süre içinde 1-5 arası yumurta verir.</span></div>`;
  return `<div class="petEggPanel"><div class="petEggHead"><b>🥚 Yumurtaları kontrol et</b><span>${eggPets.reduce((a,p)=>a+Number(p.egg_count||0),0)} yumurta</span></div>${eggPets.map(p=>`<button class="eggCheckBtn" data-hatch-egg="${p.id}">🥚 ${escapeHtml(p.name||'Avatar')} yumurtasını severek çatlat</button>`).join('')}</div>`;
}
async function openPetAdoptModal(p){
  const overlay=document.createElement('div');
  overlay.className='petPlayOverlay';
  overlay.innerHTML=`<div class="petPlayModalCard petAdoptModal petColor-${escapeHtml(p.color||'violet')}"><button class="petPlayClose" type="button">×</button><div class="petPlayTitle">${escapeHtml(p.name||'Avatar')} için yeni yuva seç</div><div class="petPlayHint">Arkadaşına sahiplendirirsen onun çiftliğinde yaşamaya devam eder. Tavuk çiftliğine sahiplendirirsen bu avatar senin hesabından tamamen silinir.</div><label class="checkRow"><input type="radio" name="adoptMode" value="friend" checked/> <span>Arkadaşıma sahiplendir</span></label><select class="input" data-adopt-user><option value="">Arkadaş seç</option></select><label class="checkRow" style="margin-top:10px"><input type="radio" name="adoptMode" value="farm"/> <span>Tavuk çiftliğine sahiplendir ve benden sil</span></label><button class="btn primary" data-confirm-adopt>Sevgiyle Sahiplendir</button><div class="muted small" data-adopt-msg></div></div>`;
  document.body.appendChild(overlay);
  const close=()=>overlay.remove(); overlay.querySelector('.petPlayClose').onclick=close; overlay.addEventListener('click',e=>{if(e.target===overlay)close();});
  const sel=overlay.querySelector('[data-adopt-user]'), msg=overlay.querySelector('[data-adopt-msg]');
  try{
    const d=await api('pet_adoption_candidates');
    const users=d.users||[];
    sel.innerHTML = `<option value="">Arkadaş seç</option>` + users.map(u=>`<option value="${u.id}">${escapeHtml(u.full_name||'')} ${u.school?`• ${escapeHtml(u.school)}`:''}</option>`).join('');
    if(!users.length) msg.textContent='Sahiplendirmek için önce bir kullanıcıyı takip etmelisin.';
  }catch(e){ msg.textContent=e.message||'Arkadaş listesi yüklenemedi.'; }
  overlay.querySelector('[data-confirm-adopt]').onclick=async()=>{
    const mode = overlay.querySelector('input[name="adoptMode"]:checked')?.value || 'friend';
    const to_user_id=Number(sel.value||0);
    if(mode === 'friend' && !to_user_id){ msg.textContent='Lütfen bir arkadaş seç.'; return; }
    const confirmText = mode === 'farm' ? 'Bu avatarı tavuk çiftliğine sahiplendirince hesabından tamamen silinecek. Emin misin?' : 'Bu civcivi seçtiğin arkadaşa sahiplendirmek istediğine emin misin?';
    if(!confirm(confirmText)) return;
    try{
      const d=await api('pet_adopt','POST',{id:p.id,to_user_id,mode});
      showAppNotice('Sahiplendirme', d.message||'Civciv sahiplendirildi.');
      close();
      await loadPets();
    }catch(e){ msg.textContent=e.message||'Sahiplendirme yapılamadı.'; }
  };
}

async function openEggHatchModal(p){
  let strokes=0;
  const overlay=document.createElement('div');
  overlay.className='petPlayOverlay';
  overlay.innerHTML=`<div class="petPlayModalCard petColor-${escapeHtml(p.color||'violet')}"><button class="petPlayClose" type="button">×</button><div class="petPlayTitle">Yumurtayı sevgiyle çatlat</div><div class="petPlayHint">Yumurtanın üstünde mouse veya parmağınla gezdir. 3 sevme hareketinden sonra yeni civciv çıkabilir.</div><div class="petPlayBig eggBig" data-egg-zone>🥚</div><div class="petPlayProgress"><i style="width:0%"></i></div><div class="petPlayMsg">Yavaşça sev 🥚</div></div>`;
  document.body.appendChild(overlay);
  const close=()=>overlay.remove(); overlay.querySelector('.petPlayClose').onclick=close; overlay.addEventListener('click',e=>{if(e.target===overlay)close();});
  const zone=overlay.querySelector('[data-egg-zone]'), bar=overlay.querySelector('.petPlayProgress i'), msg=overlay.querySelector('.petPlayMsg'); let last=0;
  const stroke=async()=>{ const now=Date.now(); if(now-last<260) return; last=now; strokes++; zone.classList.add('beingPetted'); setTimeout(()=>zone.classList.remove('beingPetted'),220); bar.style.width=`${Math.min(100,strokes*34)}%`; msg.textContent=strokes<3?'Kabuk yumuşuyor 💜':'Çatlıyor...'; if(strokes===3){ try{ const d=await api('pet_hatch_egg','POST',{id:p.id,strokes}); msg.textContent=d.message||'Civciv çıktı!'; zone.textContent='🐣'; showAppNotice('Yumurta çatladı', d.message||'Yeni civciv çıktı.'); await new Promise(r=>setTimeout(r,800)); close(); await loadPets(); }catch(e){ msg.textContent=e.message||'Yumurta çatlatılamadı.'; } } };
  zone.addEventListener('pointermove', stroke); zone.addEventListener('click', stroke); zone.addEventListener('touchmove', stroke,{passive:true});
}

async function petActionWithAnimation(btn, forcedAct){
  const box = btn.closest('.petBox') || document.querySelector('.petPlayModalCard');
  const id = Number(btn.dataset.id || btn.dataset.petId);
  const act = forcedAct || btn.dataset.petAct;
  if(!id || !act) return;
  box?.classList.remove('petActFeed','petActToilet','petActSleep','petActPlay','petActPet');
  box?.classList.add('petAct'+act.charAt(0).toUpperCase()+act.slice(1));
  btn.disabled = true;
  try{
    const d = await api('pet_action','POST',{id, care_action:act});
    showAppNotice('Avatar bakımı', `${petActionLabel(act)} işlemi tamamlandı.`);
    await new Promise(r=>setTimeout(r, 420));
    await loadPets();
  }catch(e){ setMsg($('petMsg'), e.message || 'Avatar bakımı yapılamadı.'); }
  finally{ btn.disabled = false; }
}
function openPetPlayModal(p){
  let strokes = 0;
  const overlay = document.createElement('div');
  overlay.className = 'petPlayOverlay';
  overlay.innerHTML = `<div class="petPlayModalCard petColor-${escapeHtml(p.color||'violet')}">
    <button class="petPlayClose" type="button">×</button>
    <div class="petPlayTitle">${escapeHtml(p.name||'Avatarını')} sev</div>
    <div class="petPlayHint">Mouse ile veya telefonda parmağınla civcivin üzerinde gezdir. 3 sevme hareketinden sonra mutluluğu artar.</div>
    <div class="petPlayBig" data-pet-play-zone>${petEmoji(p)}</div>
    <div class="petPlayProgress"><i style="width:0%"></i></div>
    <div class="petPlayMsg">Hazır 🐣</div>
  </div>`;
  document.body.appendChild(overlay);
  const close=()=>overlay.remove();
  overlay.querySelector('.petPlayClose').onclick=close;
  overlay.addEventListener('click', e=>{ if(e.target===overlay) close(); });
  const zone=overlay.querySelector('[data-pet-play-zone]');
  const bar=overlay.querySelector('.petPlayProgress i');
  const msg=overlay.querySelector('.petPlayMsg');
  let last=0;
  const stroke=async()=>{
    const now=Date.now(); if(now-last<260) return; last=now;
    strokes++; zone.classList.add('beingPetted'); setTimeout(()=>zone.classList.remove('beingPetted'),220);
    bar.style.width = `${Math.min(100, strokes*34)}%`;
    msg.textContent = strokes<3 ? 'Çok hoşuna gitti 💜' : 'Mutlu oldu, kaydediliyor...';
    if(strokes===3){ await petActionWithAnimation({dataset:{id:p.id,petAct:'pet'}, disabled:false, closest:()=>overlay.querySelector('.petPlayModalCard')}, 'pet'); setTimeout(close,650); }
  };
  zone.addEventListener('pointermove', stroke);
  zone.addEventListener('click', stroke);
  zone.addEventListener('touchmove', stroke, {passive:true});
}
async function savePetSettings(btn){
  const id = Number(btn.dataset.petSettings);
  const card = btn.closest('.petBox');
  const visibility = card?.querySelector('[data-pet-visibility]')?.value || 'public';
  const messages_enabled = card?.querySelector('[data-pet-messages]')?.checked ? 1 : 0;
  await api('pet_settings','POST',{id, visibility, messages_enabled});
  showAppNotice('Avatar ayarları', 'Avatar ayarların güncellendi.');
  await loadPets();
}
async function loadPetFriendCandidates(){
  const sel=$('petFriendSelect'); if(!sel) return;
  try{
    const d=await api('pet_friend_candidates');
    const users=d.users||[];
    sel.innerHTML = `<option value="">Arkadaş avatarı seç</option>` + users.map(u=>`<option value="${u.pet_id}">${escapeHtml(u.full_name||'')} • ${escapeHtml(u.pet_name||'Avatar')}</option>`).join('');
    if(!users.length) sel.innerHTML += `<option value="" disabled>Uygun avatar yok</option>`;
  }catch(e){ sel.innerHTML = `<option value="">Arkadaş listesi yüklenemedi</option>`; }
}
function friendshipCardHtml(f){
  const a=f.pet_a, b=f.pet_b;
  const conflict=f.status==='conflict';
  const side=f.viewer_side==='owner' ? f.resolved_by_owner : f.resolved_by_friend;
  return `<article class="petFriendCard ${conflict?'conflict':''}">
    <div class="petFriendPair"><div><span class="miniPetFace petColor-${escapeHtml(a.color||'violet')}">${petEmoji(a)}</span><b>${escapeHtml(a.name||'Avatar')}</b><small>${escapeHtml(a.owner_name||'')}</small></div><div class="friendLine">${conflict?'⚡':'💜'}</div><div><span class="miniPetFace petColor-${escapeHtml(b.color||'violet')}">${petEmoji(b)}</span><b>${escapeHtml(b.name||'Avatar')}</b><small>${escapeHtml(b.owner_name||'')}</small></div></div>
    ${conflict?`<div class="petConflictBox"><b>Küçük bir kavga çıktı</b><span>${escapeHtml(f.conflict_reason||'Birbirlerine biraz kırıldılar.')}</span><button class="btn primary" data-resolve-pet-conflict="${f.id}" ${Number(side)===1?'disabled':''}>${Number(side)===1?'Sen çözüm adımını attın':'Beraber Çöz'}</button></div>`:`<div class="muted small">Arkadaşlık iyi gidiyor. Bazen tartışırlarsa iki tarafın da “Beraber Çöz” demesi gerekir.</div>`}
  </article>`;
}
async function loadPetFriendships(){
  const box=$('petFriendships'); if(!box) return;
  try{
    const d=await api('pet_friendships_list');
    const rows=d.friendships||[];
    box.innerHTML = `<div class="profileSectionTitle">Avatar Arkadaşlıkları</div>` + (rows.length ? rows.map(friendshipCardHtml).join('') : `<div class="petEmpty"><b>Henüz avatar arkadaşı yok.</b><span class="muted small">Sağdan takip ettiğin birinin avatarını seçip arkadaş yapabilirsin.</span></div>`);
    box.querySelectorAll('[data-resolve-pet-conflict]').forEach(btn=>btn.onclick=async()=>{ try{ const d=await api('pet_resolve_conflict','POST',{id:Number(btn.dataset.resolvePetConflict)}); showAppNotice('Avatar arkadaşlığı', d.message || 'Çözüm adımı kaydedildi.'); await loadPets(); }catch(e){ showAppNotice('Hata', e.message || 'Kavga çözülemedi.'); } });
  }catch(e){ box.innerHTML = `<div class="muted">Avatar arkadaşlıkları yüklenemedi.</div>`; }
}
async function loadPets(){
  const list = $('petList'); if(!list) return;
  await loadPetPartners();
  await loadPetFriendCandidates();
  try{
    const d = await api('pet_list');
    let pets = d.pets || [];
    const ownPets = pets.filter(p=>Number(p.owner_id)===Number(me?.id) && ['solo','chick'].includes(p.pet_type));
    const soloPets = ownPets.filter(p=>p.pet_type==='solo');
    const primary = soloPets[0] || ownPets[0] || null;
    window.petActiveId = window.petActiveId && ownPets.some(p=>Number(p.id)===Number(window.petActiveId)) ? window.petActiveId : (primary?.id || null);
    const active = ownPets.find(p=>Number(p.id)===Number(window.petActiveId)) || primary;
    const createPanel=$('petCreatePanel');
    if(createPanel) createPanel.classList.toggle('hidden', !!primary);
    if(!primary){
      list.innerHTML = `<div class="petEmpty"><b>Henüz kendi avatarın yok.</b><span class="muted small">Yukarıdan bir isim ve renk seçip ilk civcivini oluştur.</span></div>`;
    } else {
      const hiddenCount = Math.max(0, soloPets.length-1);
      const switcher = ownPets.length>1 ? `<div class="petFarmSwitcher"><div><b>🐔 Tavuk çiftliğim</b><span class="muted small">Civcivler arası geçiş yap; büyüyen tavuk tekrar küçülmez.</span></div><div class="petSwitchList">${ownPets.map(p=>petSelectorHtml(p, active?.id)).join('')}</div></div>` : '';
      const farmFiller = `<div class="petFarmFiller"><div><b>Çiftlik günlüğü</b><span>Bugün bakım yapınca çiftliğin dolu görünür, yaş sistemi hızlandırılmış avatar takvimine göre işler.</span></div><div class="petFarmPath"><span>🐣 Civciv</span><i></i><span>🐥 Büyür</span><i></i><span>🐔 Tavuk</span><i></i><span>🥚 Yumurta</span></div></div>`;
      list.innerHTML = switcher + (active ? petCardHtml(active,{active:true}) : '') + eggPanelHtml(ownPets, active) + farmFiller + (hiddenCount?`<div class="petHiddenNote">${hiddenCount} eski/tekrar ana avatar gizlendi. Yeni yavrular yumurtadan çıkarak çiftliğe eklenir.</div>`:'');
    }
    list.querySelectorAll('[data-switch-pet]').forEach(btn=>btn.onclick=()=>{ window.petActiveId=Number(btn.dataset.switchPet); loadPets(); });
    list.querySelectorAll('[data-hatch-egg]').forEach(btn=>btn.onclick=()=>{ const p=ownPets.find(x=>Number(x.id)===Number(btn.dataset.hatchEgg)); if(p) openEggHatchModal(p); });
    list.querySelectorAll('[data-pet-act]').forEach(btn=>btn.onclick=()=>petActionWithAnimation(btn));
    list.querySelectorAll('[data-open-pet-play]').forEach(btn=>btn.onclick=()=>{ const petId=Number(btn.dataset.openPetPlay); const p=pets.find(x=>Number(x.id)===petId); if(p) openPetPlayModal(p); });
    list.querySelectorAll('[data-pet-settings]').forEach(btn=>btn.onclick=async()=>{ try{ await savePetSettings(btn); }catch(e){ setMsg($('petMsg'), e.message || 'Ayar kaydedilemedi.'); } });
    list.querySelectorAll('[data-pet-rename]').forEach(btn=>btn.onclick=async()=>{ const name=prompt('Yeni avatar adı:', btn.dataset.name || ''); if(name===null) return; await api('pet_rename','POST',{id:Number(btn.dataset.petRename), name:String(name).trim()}); await loadPets(); });
    list.querySelectorAll('[data-pet-delete]').forEach(btn=>btn.onclick=async()=>{ if(!confirm('Bu avatarı listenden kaldırıyorsun. Birden fazla avatarın varsa bu işlem sahiplendirme/silme gibi çalışır ve avatar sende görünmez. Devam edilsin mi?')) return; await api('pet_delete','POST',{id:Number(btn.dataset.petDelete)}); await loadPets(); });
    list.querySelectorAll('[data-pet-adopt]').forEach(btn=>btn.onclick=()=>{ const id=Number(btn.dataset.petAdopt); const p=ownPets.find(x=>Number(x.id)===id); if(p) openPetAdoptModal(p); });
    updatePetSidePanel(pets);
    await loadPetFriendships();
  }catch(e){ list.innerHTML = `<div class="muted">${escapeHtml(e.message||'Avatarlar yüklenemedi.')}</div>`; }
}
async function loadProfilePets(userId){
  const box = document.getElementById('profilePetPreview');
  if(!box) return;
  try{
    const d = await api('pet_public_list','GET',{user_id:userId});
    const pets = d.pets || [];
    if(!pets.length){ box.innerHTML = `<span class="muted small">Görünen avatar yok.</span>`; return; }
    box.innerHTML = pets.slice(0,1).map(p=>`<div class="profilePetChip petColor-${escapeHtml(p.color||'violet')}"><span>${petEmoji(p)}</span><b>${escapeHtml(p.name||'Avatar')}</b><small>${petStageName(p)} • ${petAgeText(p)}</small></div>`).join('');
  }catch(e){ box.innerHTML = `<span class="muted small">Avatarlar yüklenemedi.</span>`; }
}
function bindPetUi(){
  const create=$('btnCreatePet'); if(create && create.dataset.bound!=='1'){
    create.dataset.bound='1';
    create.onclick=async()=>{
      try{
        setMsg($('petMsg'),'');
        const name=($('petNameInput')?.value||'').trim();
        const color=$('petColorSelect')?.value || 'violet';
        await api('pet_create','POST',{name,pet_type:'solo',partner_id:0,color});
        $('petNameInput').value='';
        setMsg($('petMsg'),'✅ Avatar oluşturuldu.');
        await loadPets();
      }catch(e){ setMsg($('petMsg'), e.message || 'Avatar oluşturulamadı.'); }
    };
  }
  const refresh=$('btnRefreshPets'); if(refresh && refresh.dataset.bound!=='1'){ refresh.dataset.bound='1'; refresh.onclick=()=>loadPets(); }
  const make=$('btnMakePetFriend'); if(make && make.dataset.bound!=='1'){
    make.dataset.bound='1';
    make.onclick=async()=>{ try{ const friend_pet_id=Number($('petFriendSelect')?.value||0); if(!friend_pet_id) throw new Error('Arkadaş yapılacak avatarı seç.'); const d=await api('pet_make_friend','POST',{friend_pet_id}); setMsg($('petFriendMsg'), '✅ '+(d.message||'Avatarlar arkadaş oldu.')); await loadPets(); }catch(e){ setMsg($('petFriendMsg'), e.message || 'Arkadaşlık kurulamadı.'); } };
  }
}

async function refreshStats(){
  try{
    const d = await api("stats");
    statUsers.textContent = d.total_users ?? "-";
    statFarewells.textContent = d.total_farewells ?? "-";
    statTop.textContent = d.top_user ? `${d.top_user.full_name} (${d.top_user.count})` : "-";
  }catch(_){}
}

async function refreshProfileBadges(){
  if(!me) return;
  try{
    const d = await api('profile_badges');
    profileBadgeState = { follow_requests:Number(d.follow_requests||0), dm_unread:Number(d.dm_unread||0) };
  }catch(_){
    profileBadgeState = { follow_requests:0, dm_unread:0 };
  }
  const reqEl = $('statProfileRequests');
  const dmEl = $('statProfileDmUnread');
  const reqBadge = $('profileFollowReqBadge');
  const dmBadge = $('profileDmBadge');
  if(reqEl) reqEl.textContent = String(profileBadgeState.follow_requests);
  if(dmEl) dmEl.textContent = String(profileBadgeState.dm_unread);
  if(reqBadge){ reqBadge.textContent = String(profileBadgeState.follow_requests); reqBadge.classList.toggle('hidden', !profileBadgeState.follow_requests); }
  if(dmBadge){ dmBadge.textContent = String(profileBadgeState.dm_unread); dmBadge.classList.toggle('hidden', !profileBadgeState.dm_unread); }
  const reqBox = reqEl?.closest('.profileStatBox');
  const dmBox = dmEl?.closest('.profileStatBox');
  if(reqBox) reqBox.onclick = ()=>setTab('inbox');
  if(dmBox) dmBox.onclick = ()=>btnDM.click();
}

async function loadUsers(){
  const q = search.value.trim();
  const school = filterSchool.value.trim();
  const year = filterYear.value;
  const params = {};
  if(q) params.q = q;
  if(school) params.school = school;
  if(year) params.grad_year = year;
  const d = await api("users","GET", Object.keys(params).length?params:null);
  renderUserList(d.users || []);
}

function profileHeaderHtml(u){
  const isOther = me && u && me.id !== u.id;
  const isMe = me && u && me.id === u.id;
  const heroActions = isOther
    ? `<div id="followControls" class="profileActionRail"></div>`
    : `<div class="profileActionRail"><button class="btn primary" id="btnHeroEditProfile">${t('editProfile')}</button><button class="btn" id="btnHeroShareTab">${t('shareNewPhoto')}</button><button class="btn" id="btnHeroGalleryTab">${t('photos')}</button><button class="btn" id="btnHeroDM">DM</button></div>`;
  const coverStyle = u?.cover_photo_url ? ` style="background-image:url('${escapeHtml(resolveUrl(u.cover_photo_url))}')"` : '';
  const verified = u?.verified_badge ? `<span class="verifiedBadge" title="${t('verifiedTitle')}">✔</span>` : '';
  return `<div class="profileHero premiumHero">
    <div class="profileCover"${coverStyle}>
      <div class="profileCoverOverlay"></div>
      ${isMe ? `<button class="btn coverUploadBtn" id="btnHeroCoverTab">${t('editCover')}</button>` : ''}
    </div>
    <div class="profileHeroMain premiumHeroMain">
      <div class="profileHeroAvatar">${avatarHtml(u)}</div>
      <div class="profileHeroIdentity">
        <div class="profileHeroEyebrow">${t('profileHeroEyebrowText')}</div>
        <div class="profileHeroName">${escapeHtml(u.full_name)} ${verified}</div>
        <div class="profileHeroMetaRow">
          <span class="profileHeroMetaChip">${t('schoolLabel')}: ${escapeHtml(u.school || "—")}</span>
          <span class="profileHeroMetaChip">${t('gradLabel')}: ${u.grad_year || "—"}</span>
        </div>
        <div class="profileHeroBio">${escapeHtml(u.bio || (isMe ? t('profileBioEmptySelf') : t('profileBioEmptyOther')))}</div>
      </div>
    </div>
    ${heroActions}
    <div id="profileStatsBar" class="profileStatsBar">
      <div class="profileStatBox profileBadgeBox"><span>🔔</span><b id="statProfileRequests">0</b><small>${t('followRequestsSmall')}</small><em class="miniBadge" id="profileFollowReqBadge">0</em></div>
      <div class="profileStatBox profileBadgeBox"><span>💬</span><b id="statProfileDmUnread">0</b><small>${t('unreadDmSmall')}</small><em class="miniBadge" id="profileDmBadge">0</em></div>
      <div class="profileStatBox"><span>👥</span><b id="statProfileFollowers">0</b><small>${t('followers')}</small></div>
      <div class="profileStatBox"><span>➡️</span><b id="statProfileFollowing">0</b><small>${t('following')}</small></div>
      <div class="profileStatBox"><span>🖼️</span><b id="statProfilePhotos">0</b><small>${t('photos')}</small></div>
    </div>
  </div>`;
}


async function openDmWithUser(otherId, otherName=""){
  const r = await api("dm_open_with","GET",{user_id: otherId});
  const list = await api("dm_list");
  const items = list.items || [];
  renderDmList(items);
  let thread = items.find(x => (x.thread_kind || 'direct') === 'direct' && Number(x.conversation_id||0) === Number(r.conversation_id));
  if(!thread){
    thread = { thread_kind:'direct', conversation_id:r.conversation_id, with:{ id:otherId, full_name:otherName || 'Sohbet' } };
  }
  switchView("dm");
  await openDmThreadItem(thread, t("openDmPrompt"));
  dmInput.focus();
}


async function updateFollowControls(otherId){
  const el = document.getElementById("followControls");
  if(!el) return;
  try{
    const st = await api("follow_status","GET",{user_id: otherId});
    const following = !!st.following;
    const mutual = !!st.mutual;
    const requestSent = !!st.request_sent;
    const requestReceived = !!st.request_received;
    const selectedIsAdmin = Number(selectedUser?.is_admin || 0) === 1 || String(selectedUser?.email||"").toLowerCase()==="admin@mera.com";
    const meIsAdmin = Number(me?.is_admin || 0) === 1;
    const isOpenAccount = st.account_privacy === "public" || st.open_account === true;
    const followText = following ? t("unfollow") : (requestSent ? t("requestSent") : (isOpenAccount ? "Takip Et" : t("follow")));
    const isPublicAccount = (selectedUser?.account_privacy || st.account_privacy || "private") === "public" || st.open_account === true;
    const canMessage = mutual || selectedIsAdmin || meIsAdmin || (selectedUser?.dm_privacy || "everyone") === "everyone" || isPublicAccount;
    const msgDisabled = !canMessage;
    let extra = mutual ? t("mutual") : ((selectedIsAdmin || meIsAdmin) ? "Admin için DM serbest" : (isPublicAccount ? "Açık hesap: DM serbest" : (canMessage ? "DM açık" : t("mutualReq"))));
    const followBtnClass = (following || requestSent) ? "" : "primary";
    const msgDisabledAttr = msgDisabled ? "disabled" : "";
    const moderationActions = selectedIsAdmin ? `<span class="pill good">Admin hesabı engellenemez/şikayet edilemez</span>` : `<button class="btn" id="btnReportUser">Şikayet Et</button><button class="btn" id="btnBlockUser">Engelle</button>`;
    let actionRow = `
      <button class="btn ${followBtnClass}" id="btnFollow">${followText}</button>
      <button class="btn primary" id="btnMessage" ${msgDisabledAttr}>${t("message")}</button>
      ${moderationActions}`;
    if(requestReceived){
      extra = t("requestReceived");
      actionRow += `
      <button class="btn primary" id="btnAcceptFollow">${t("accept")}</button>
      <button class="btn" id="btnRejectFollow">${t("reject")}</button>`;
    }
    el.innerHTML = `${actionRow}<span class="muted small">${extra}</span>`;

    const followBtn = $("btnFollow");
    if(followBtn) followBtn.onclick = async ()=>{
      await api("follow_toggle","POST",{user_id: otherId});
      await updateFollowControls(otherId);
      if(me && me.id===selectedUser?.id) await loadMyInbox();
    };

    const acceptBtn = $("btnAcceptFollow");
    if(acceptBtn) acceptBtn.onclick = async ()=>{
      await api("follow_request_respond","POST",{request_id: st.request_id, decision:'accept'});
      await updateFollowControls(otherId);
      if(me && me.id===selectedUser?.id) await loadMyInbox();
    };
    const rejectBtn = $("btnRejectFollow");
    if(rejectBtn) rejectBtn.onclick = async ()=>{
      await api("follow_request_respond","POST",{request_id: st.request_id, decision:'reject'});
      await updateFollowControls(otherId);
      if(me && me.id===selectedUser?.id) await loadMyInbox();
    };

    const msgBtn = $("btnMessage");
    if(msgBtn) msgBtn.onclick = async ()=>{
      if(msgDisabled){
        switchView('dm');
        return setMsg(dmMsg, t('mutualReq'));
      }
      try{
        await openDmWithUser(otherId, selectedUser?.full_name || "");
      }catch(e){
        switchView('dm');
        setMsg(dmMsg, e.message || t("dmServerIssue"));
      }
    };
    const reportBtn = $("btnReportUser");
    if(reportBtn) reportBtn.onclick = async ()=> reportUser(otherId, selectedUser?.full_name || "");
    const blockBtn = $("btnBlockUser");
    if(blockBtn) blockBtn.onclick = async ()=> blockUser(otherId, selectedUser?.full_name || "");
  }catch(e){
    el.innerHTML = `<span class="muted small">${escapeHtml(e.message||"")}</span>`;
  }
}

async function updateFollowCounts(userId){
  try{
    const c = await api('follow_counts','GET',{user_id:userId});
    const followers = Number(c.followers||0);
    const following = Number(c.following||0);
    const followersEl = $('statProfileFollowers');
    const followingEl = $('statProfileFollowing');
    if(followersEl) followersEl.textContent = String(followers);
    if(followingEl) followingEl.textContent = String(following);

    const statsBar = $('profileStatsBar');
    if(statsBar){
      statsBar.querySelectorAll('[data-openfollows]').forEach(x=>x.removeAttribute('data-openfollows'));
      const boxes = statsBar.querySelectorAll('.profileStatBox');
      if(boxes[2]){ boxes[2].dataset.openfollows='followers'; boxes[2].style.cursor='pointer'; boxes[2].onclick=()=>openFollowsModal(userId,'followers'); }
      if(boxes[3]){ boxes[3].dataset.openfollows='following'; boxes[3].style.cursor='pointer'; boxes[3].onclick=()=>openFollowsModal(userId,'following'); }
    }
  }catch(e){
    const followersEl = $('statProfileFollowers');
    const followingEl = $('statProfileFollowing');
    if(followersEl) followersEl.textContent = '-';
    if(followingEl) followingEl.textContent = '-';
  }
}

async function openFollowsModal(userId, type){
  if(!followsModal) return;
  followsModal.classList.remove('hidden');
  followsList.innerHTML = `<p class="muted">${t("loading")}</p>`;
  followsTitle.textContent = type==='followers' ? t('followers') : t('following');
  try{
    const d = await api('follow_list','GET',{user_id:userId,type});
    const items = d.items || [];
    if(items.length===0){
      followsList.innerHTML = `<p class="muted">${t("emptyList")}</p>`;
      return;
    }
    followsList.innerHTML = items.map(u=>{
      const showFollowBack = !!u.can_follow_back;
      const followLabel = u.request_sent ? 'İstek Gönderildi' : 'Geri Takip Et';
      return `
      <div class="followCard" data-uid="${u.id}">
        <div class="followCardMain">
          <div>${avatarHtml(u)}</div>
          <div style="min-width:0;flex:1">
            <div><b>${escapeHtml(u.full_name||'')}</b>${u.mutual ? ' <span class="muted small">• Takipleşiliyor</span>' : ''}</div>
            <div class="muted small">${escapeHtml(u.school||'—')} • ${u.grad_year||'—'}</div>
          </div>
        </div>
        <div class="followCardActions">
          <button class="btn" data-openprofile="${u.id}">Profili Aç</button>
          ${showFollowBack ? `<button class="btn primary" data-followback="${u.id}" ${u.request_sent ? 'disabled' : ''}>${followLabel}</button>` : ``}
          ${(u.mutual || Number(u.is_admin||0)===1 || String(u.email||'').toLowerCase()==='admin@mera.com' || (u.account_privacy||'private')==='public' || (u.dm_privacy||'everyone')==='everyone') ? `<button class="btn primary" data-dmuser="${u.id}" data-name="${escapeHtml(u.full_name||'')}">Mesajlaş</button>` : ``}
        </div>
      </div>`;
    }).join('');

    followsList.querySelectorAll('[data-openprofile]').forEach(btn=>btn.onclick = async ()=>{ await selectUser(Number(btn.dataset.openprofile)); followsModal.classList.add('hidden'); });
    followsList.querySelectorAll('[data-followback]').forEach(btn=>btn.onclick = async ()=>{
      try{
        await api('follow_toggle','POST',{user_id:Number(btn.dataset.followback)});
        await openFollowsModal(userId, type);
      }catch(e){ setMsg(appMsg, e.message || 'Takip hatası'); }
    });
    followsList.querySelectorAll('[data-dmuser]').forEach(btn=>btn.onclick = async ()=>{
      try{
        followsModal.classList.add('hidden');
        await openDmWithUser(Number(btn.dataset.dmuser), btn.dataset.name || '');
      }catch(e){ setMsg(appMsg, e.message || 'DM açılamadı.'); }
    });
  }catch(e){
    followsList.innerHTML = `<p class="muted">${escapeHtml(e.message||'Hata')}</p>`;
  }
}


async function loadBadgeRequestStatus(){
  const statusEl = $("badgeRequestStatus");
  const btn = $("btnSendBadgeRequest");
  const input = $("badgeRequestText");
  if(!statusEl || !btn) return;
  try{
    const d = await api("badge_request_status");
    if(Number(d.verified_badge||0)===1){
      statusEl.innerHTML = "✅ Hesabında doğrulanmış rozet var.";
      btn.disabled = true;
      if(input) input.disabled = true;
      return;
    }
    const r = d.request;
    btn.disabled = !d.can_request;
    if(input) input.disabled = !d.can_request;
    if(!r){
      statusEl.textContent = "Henüz rozet talebin yok.";
    }else if(r.status === "pending"){
      statusEl.innerHTML = `⏳ Son talebin inceleniyor. <br><span>${escapeHtml(r.created_at||"")}</span>`;
    }else if(r.status === "approved"){
      statusEl.textContent = "✅ Son talebin onaylandı.";
    }else if(r.status === "rejected"){
      statusEl.innerHTML = `❌ Son talebin onaylanmadı. ${d.can_request ? "Tekrar başvuru yapabilirsin." : `${d.wait_days||3} gün sonra tekrar deneyebilirsin.`}${r.admin_note ? `<br>Admin notu: ${escapeHtml(r.admin_note)}` : ""}`;
    }else{
      statusEl.textContent = "Rozet talebi durumu yüklenemedi.";
    }
  }catch(e){
    statusEl.textContent = e.message || "Rozet talebi durumu yüklenemedi.";
  }
}

async function sendBadgeRequest(){
  const input = $("badgeRequestText");
  const msgEl = $("badgeRequestMsg");
  try{
    setMsg(msgEl, "");
    const message = (input?.value || "").trim();
    if(message.length < 20) throw new Error("Lütfen hesabını en az 20 karakterle anlat.");
    await api("badge_request_create", "POST", {message});
    if(input) input.value = "";
    setMsg(msgEl, "✅ Rozet talebin admine gönderildi.");
    await loadBadgeRequestStatus();
  }catch(e){ setMsg(msgEl, e.message || "Talep gönderilemedi."); }
}

function renderProfilePanel(u){
  const isMe = (me && u && me.id===u.id);
  const musicBlock = (u.profile_music_url)
    ? `<div class="profileSection profileCompactCard">
        <div class="profileSectionTitle">${t('profileMusic')}</div>
        <div class="profileInfoStack">
          <div><b>${escapeHtml(u.profile_music_platform || "")}</b></div>
          <div class="muted"><a href="${escapeHtml(u.profile_music_url)}" target="_blank" rel="noreferrer">${t('link')}</a></div>
        </div>
      </div>` : "";

  if(!isMe){
    panelProfile.innerHTML = `
      <div class="profileShell">
        <div class="profileColumns profileColumnsReadOnly">
          <div class="profileSection">
            <div class="profileSectionTitle">${t('profileInfo')}</div>
            <div class="profileInfoGrid">
              <div class="profileInfoItem"><span class="muted small">${t('email')}</span><b>${escapeHtml(u.email || '—')}</b></div>
              <div class="profileInfoItem"><span class="muted small">${t('school')}</span><b>${escapeHtml(u.school || '—')}</b></div>
              <div class="profileInfoItem"><span class="muted small">${t('classLabel')}</span><b>${escapeHtml(u.class_label || '—')}</b></div>
              <div class="profileInfoItem"><span class="muted small">${t('instagram')}</span><b>${escapeHtml(u.instagram || '—')}</b></div>
              <div class="profileInfoItem"><span class="muted small">${t('phone')}</span><b>${escapeHtml(u.phone || '—')}</b></div>
            </div>
            <div class="profileBioBox">
              <div class="muted small">${t('biography')}</div>
              <div>${escapeHtml(u.bio || '—')}</div>
            </div>
          </div>

          <div class="profileStackCol">
            <div class="profileSection profileCompactCard">
              <div class="profileSectionTitle">${t('quickActions')}</div>
              <div class="profileActionList">
                <button class="btn primary" id="btnStartDmFromProfile">${t('message')}</button>
                <span class="muted small">${((Number(u.is_admin||0)===1 || String(u.email||'').toLowerCase()==='admin@mera.com' || (u.account_privacy||'private')==='public' || (u.dm_privacy||'everyone')==='everyone') ? "DM serbest" : t('mutualReq'))}</span>
              </div>
            </div>

            <div class="profileSection profileCompactCard">
              <div class="profileSectionTitle">${t('sendFarewell')}</div>
              <textarea class="input" id="farewellText" placeholder="${t('farewellPlaceholder')}"></textarea>
              <div class="row" style="margin-top:8px">
                <select class="input" id="fwMusicPlatform">
                  <option value="">${t('songPlatform')}</option>
                  <option value="spotify">Spotify</option>
                  <option value="youtube">YouTube</option>
                </select>
                <input class="input" id="fwMusicUrl" placeholder="${t('songLink')}"/>
              </div>
              <div class="profileInlineActions">
                <button class="btn primary" id="btnSendFarewell">${t('send')}</button>
                <span class="muted" id="farewellMsg"></span>
              </div>
            </div>

            <div class="profileSection profileCompactCard">
              <div class="profileSectionTitle">Avatarları</div>
              <div id="profilePetPreview" class="profilePetPreview"><span class="muted small">Yükleniyor...</span></div>
            </div>
            ${musicBlock}
          </div>
        </div>

        <div id="photoPostsWrap" class="profileSection profileGallerySection"></div>
      </div>
    `;
    const dmBtn = $("btnStartDmFromProfile");
    if(dmBtn) dmBtn.onclick = async ()=>{
      try{
        await openDmWithUser(u.id, u.full_name || "");
      }catch(e){
        switchView('dm');
        setMsg(dmMsg, e.message || t("dmServerIssue"));
      }
    };
    renderPhotoPosts(u.id, false);
    if(typeof loadProfilePets === 'function') loadProfilePets(u.id);
    const btn = $("btnSendFarewell");
    if(btn){
      btn.onclick = async ()=>{
        try{
          setMsg($("farewellMsg"),"");
          const message = $("farewellText").value.trim();
          if(!message) throw new Error(t("writeMessageErr"));
          const mp = $("fwMusicPlatform").value;
          const mu = $("fwMusicUrl").value.trim();
          await api("add_farewell","POST",{to_user_id:u.id,message, music_platform: mp, music_url: mu});
          $("farewellText").value="";
          $("fwMusicPlatform").value="";
          $("fwMusicUrl").value="";
          setMsg($("farewellMsg"),t("sentOk"));
          await selectUser(u.id);
          setTab("farewells");
        }catch(e){ setMsg($("farewellMsg"), e.message); }
      };
    }
    return;
  }

  panelProfile.innerHTML = `
    <div class="profileShell">
      <div class="profileTabsMini" id="profileMiniTabs">
        <button class="profileMiniTab active" data-profilemini="edit">${t('editProfile')}</button>
        <button class="profileMiniTab" data-profilemini="share">${t('shareNewPhoto')}</button>
        <button class="profileMiniTab" data-profilemini="gallery">${t('photos')}</button>
      </div>

      <div class="profileMiniPanel" data-profilepanel="edit">
        <div class="profileColumns premiumProfileColumns">
          <div class="profileSection">
            <div class="profileSectionTitle">${t('editProfile')}</div>
            <div class="profileFormGrid">
              <div class="profileField"><label class="small muted">${t('fullName')}</label><input class="input" id="editName"/></div>
              <div class="profileField"><label class="small muted">${t('school')}</label><input class="input" id="editSchool"/></div>
              <div class="profileField"><label class="small muted">${t('classLabel')}</label><input class="input" id="editClass" placeholder="${t('classPlaceholder')}"/></div>
              <div class="profileField"><label class="small muted">${t('gradYear')}</label><input class="input" id="editYear" inputmode="numeric"/></div>
              <div class="profileField"><label class="small muted">${t('instagram')}</label><input class="input" id="editIg"/></div>
              <div class="profileField"><label class="small muted">${t('phone')}</label><input class="input" id="editPhone"/></div>
              <div class="profileField profileFieldWide"><label class="small muted">${t('profileMusic')}</label>
                <div class="row" style="grid-template-columns:1fr 1fr">
                  <select class="input" id="editMusicPlatform">
                    <option value="">${t('platform')}</option>
                    <option value="spotify">Spotify</option>
                    <option value="youtube">YouTube</option>
                  </select>
                  <input class="input" id="editMusicUrl" placeholder="Link"/>
                </div>
              </div>
              <div class="profileField profileFieldWide"><label class="small muted">${t('biography')}</label><textarea class="input" id="editBio"></textarea></div>
            </div>
            <div class="profileInlineActions">
              <button class="btn primary" id="btnSaveProfile">${t('save')}</button>
              <span class="muted" id="saveMsg"></span>
            </div>
            <div class="profileUtilityGrid">
              <div class="profileSection profileCompactCard">
                <div class="profileSectionTitle">${t('profilePhoto')}</div>
                <div class="muted small">${t('photoTip')}</div>
                <input type="file" id="photoFile" accept="image/*" class="input" style="margin-top:10px"/>
                <div class="profileInlineActions">
                  <button class="btn primary" id="btnUploadPhoto">${t('uploadPhoto')}</button>
                  <button class="btn" id="btnClearPhoto">${t('cancel')}</button>
                </div>
                <span class="muted" id="photoMsg"></span>
              </div>
              <div class="profileSection profileCompactCard">
                <div class="profileSectionTitle">Kapak & Rozet</div>
                <input type="file" id="coverPhotoFile" accept="image/*" class="input" style="margin-top:10px"/>
                <div class="profileInlineActions">
                  <button class="btn" id="btnUploadCover">Kapak Fotoğrafı Yükle</button>
                </div>
                <div class="muted small">Doğrulanmış rozet yalnızca admin onayıyla verilir.</div>
                <span class="muted" id="coverMsg"></span>
              </div>
              <div class="profileSection profileCompactCard compactSettingsCard badgeRequestCard">
              <div class="profileSectionTitle">Rozet Talebi</div>
              <div class="muted small">Hesabının neden doğrulanmış rozet alması gerektiğini anlat. Admin onaylarsa profilinde rozet görünür.</div>
              <textarea class="input" id="badgeRequestText" rows="4" placeholder="Örn: Hesabım gerçek okul/mezun bilgilerimi içeriyor, aktif ve güvenilir kullanıyorum..."></textarea>
              <div class="profileInlineActions compactActions">
                <button class="btn primary" id="btnSendBadgeRequest">Rozet talebi gönder</button>
                <span class="muted" id="badgeRequestMsg"></span>
              </div>
              <div id="badgeRequestStatus" class="muted small" style="margin-top:8px">Yükleniyor...</div>
              </div>
              ${musicBlock ? `<div class="profileUtilityWide">${musicBlock}</div>` : ``}
            </div>
          </div>

          <div class="profileStackCol">
            <div class="profileSection profileCompactCard profileMessagingCard compactSettingsCard">
              <div class="profileSectionTitle">Mesajlaşma</div>
              <div class="compactSettingLine">
                <div><b>Mesaj izni</b><span class="muted small">DM gönderebilecek kişileri seç.</span></div>
                <select class="input compactSelect" id="dmPrivacySelect">
                  <option value="everyone">Herkes mesaj atabilir</option>
                  <option value="mutual">Sadece karşılıklı takip ettiklerim</option>
                </select>
              </div>
              <div class="profileInlineActions compactActions">
                <button class="btn primary" id="btnSaveDmPrivacy">Mesaj iznini kaydet</button>
                <span class="muted" id="dmPrivacyMsg"></span>
              </div>
            </div>

            <div class="profileSection profileCompactCard compactSettingsCard">
              <div class="profileSectionTitle">Hesap Gizliliği</div>
              <div class="compactSettingLine">
                <div><b>Hesap türü</b><span class="muted small">Açık hesapta takip isteği otomatik kabul edilir.</span></div>
                <select class="input compactSelect" id="accountPrivacySelect">
                  <option value="private">Kapalı hesap</option>
                  <option value="public">Açık hesap</option>
                </select>
              </div>
              <div class="profileInlineActions compactActions">
                <button class="btn" id="btnSaveAccountPrivacy">Hesap türünü kaydet</button>
                <span class="muted" id="accountPrivacyMsg"></span>
              </div>
            </div>

            <div class="profileSection profileCompactCard compactSettingsCard notificationSettingsCard">
              <div class="profileSectionTitle">Bildirim Ayarları</div>
              <div class="compactSettingLine notificationLine">
                <div><b>Yandan DM bildirimi</b><span class="muted small">Kapalıysa DM uyarısı ekranda açılmaz, Bildirimler’de kalır.</span></div>
                <button class="profileToggleBtn" type="button" id="dmSidebarAlertsToggle" aria-pressed="true"><span></span><b>Açık</b></button>
                <input type="checkbox" id="dmSidebarAlertsEnabled" class="hidden"/>
              </div>
              <div class="profileInlineActions compactActions">
                <button class="btn" id="btnSaveNotificationSettings">Bildirim ayarını kaydet</button>
                <span class="muted" id="notificationSettingsMsg"></span>
              </div>
            </div>

            ${Number(u.is_admin||0)===1 ? `<div class="profileSection profileCompactCard compactSettingsCard">
              <div class="profileSectionTitle">Admin Arama Ayarı</div>
              <div class="compactSettingLine notificationLine">
                <div><b>Admin aranabilir</b><span class="muted small">Kapalıysa kullanıcılar sana sesli/görüntülü arama başlatamaz.</span></div>
                <button class="profileToggleBtn" type="button" id="adminCallAllowedToggle" aria-pressed="true"><span></span><b>Açık</b></button>
                <input type="checkbox" id="adminCallAllowed" class="hidden"/>
              </div>
              <div class="profileInlineActions compactActions">
                <button class="btn" id="btnSaveAdminCallSettings">Admin arama ayarını kaydet</button>
                <span class="muted" id="adminCallSettingsMsg"></span>
              </div>
            </div>` : ``}

            <div class="profileSection profileCompactCard compactSettingsCard">
              <div class="profileSectionTitle">Gizlilik & Engeller</div>
              <label class="small muted">Profilime kim baktı kısmını kim görebilir?</label>
              <select class="input" id="profileViewsPrivacySelect" style="margin-top:8px">
                <option value="private">Sadece ben görebilirim</option>
                <option value="public">Herkese açık</option>
              </select>
              <div class="profileInlineActions compactActions">
                <button class="btn" id="btnSaveProfileViewsPrivacy">Bu ayarı kaydet</button>
                <span class="muted" id="profileViewsPrivacyMsg"></span>
              </div>
              <div class="small muted" style="margin-top:10px">Engellediğin kişiler</div>
              <div id="blockedUsersList" class="blockedUsersList"><span class="muted small">Yükleniyor...</span></div>
            </div>
            <div class="profileSection profileCompactCard">
              <div class="profileSectionTitle">Şikayetlerim</div>
              <div class="muted small">Gönderdiğin şikayetleri 3 gün içinde düzenleyebilir veya silebilirsin. Son gün iki kere hatırlatma gösterilir.</div>
              <div id="myReportsList" class="myReportsList"><span class="muted small">Yükleniyor...</span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="profileMiniPanel hidden" data-profilepanel="share">
        <div class="profileSection premiumShareCard">
          <div class="profileSectionTitle">${t('shareNewPhoto')}</div>
          <div class="muted small">${t('postTip')}</div>
          <div class="profileShareGrid">
            <input class="input" id="postCaption" placeholder="${t('caption')}"/>
            <input class="input" id="postPhoto" type="file" accept="image/*"/>
          </div>
          <div class="profileInlineActions">
            <button class="btn primary" id="btnSharePhoto">${t('sharePhoto')}</button>
            <button class="btn" id="btnOpenGalleryTab">${t('photos')}</button>
            <span class="muted" id="postMsg"></span>
          </div>
        </div>
      </div>

      <div class="profileMiniPanel hidden" data-profilepanel="gallery">
        <div id="photoPostsWrap" class="profileSection profileGallerySection"></div>
      </div>
    </div>
  `;
  $("editName").value = u.full_name || "";
  $("editSchool").value = u.school || "";
  if($("editClass")) $("editClass").value = u.class_label || "";
  $("editYear").value = u.grad_year || "";
  $("editIg").value = u.instagram || "";
  $("editPhone").value = u.phone || "";
  $("editBio").value = u.bio || "";
  $("editMusicPlatform").value = u.profile_music_platform || "";
  $("editMusicUrl").value = u.profile_music_url || "";
  const __dmPrivacySelect = $("dmPrivacySelect");
  if(__dmPrivacySelect) __dmPrivacySelect.value = u.dm_privacy || "everyone";
  const __dmSidebarAlertsEnabled = $("dmSidebarAlertsEnabled");
  const __dmSidebarAlertsToggle = $("dmSidebarAlertsToggle");
  const __syncDmSidebarToggle = ()=>{
    if(!__dmSidebarAlertsEnabled || !__dmSidebarAlertsToggle) return;
    const on = !!__dmSidebarAlertsEnabled.checked;
    __dmSidebarAlertsToggle.classList.toggle("is-on", on);
    __dmSidebarAlertsToggle.setAttribute("aria-pressed", on ? "true" : "false");
    const label = __dmSidebarAlertsToggle.querySelector("b");
    if(label) label.textContent = on ? "Açık" : "Kapalı";
  };
  if(__dmSidebarAlertsEnabled) __dmSidebarAlertsEnabled.checked = Number(u.dm_sidebar_alerts_enabled ?? 1) === 1;
  __syncDmSidebarToggle();
  if(__dmSidebarAlertsToggle) __dmSidebarAlertsToggle.onclick = ()=>{
    __dmSidebarAlertsEnabled.checked = !__dmSidebarAlertsEnabled.checked;
    __syncDmSidebarToggle();
  };
  const __adminCallAllowed = $("adminCallAllowed");
  const __adminCallAllowedToggle = $("adminCallAllowedToggle");
  const __syncAdminCallToggle = ()=>{
    if(!__adminCallAllowed || !__adminCallAllowedToggle) return;
    const on = !!__adminCallAllowed.checked;
    __adminCallAllowedToggle.classList.toggle("is-on", on);
    __adminCallAllowedToggle.setAttribute("aria-pressed", on ? "true" : "false");
    const label = __adminCallAllowedToggle.querySelector("b");
    if(label) label.textContent = on ? "Aranabilir" : "Aranamaz";
  };
  if(__adminCallAllowed) __adminCallAllowed.checked = Number(u.admin_call_allowed ?? 1) === 1;
  __syncAdminCallToggle();
  if(__adminCallAllowedToggle) __adminCallAllowedToggle.onclick = ()=>{
    __adminCallAllowed.checked = !__adminCallAllowed.checked;
    __syncAdminCallToggle();
  };
  const __btnSaveDmPrivacy = $("btnSaveDmPrivacy");
  if(__btnSaveDmPrivacy) __btnSaveDmPrivacy.onclick = async ()=>{
    try{
      setMsg($("dmPrivacyMsg"), "");
      const d = await api("dm_privacy_update","POST",{dm_privacy: __dmPrivacySelect.value});
      setMe(d.user); selectedUser = d.user;
      setMsg($("dmPrivacyMsg"), "✅ Kaydedildi.");
    }catch(e){ setMsg($("dmPrivacyMsg"), e.message || "Kaydedilemedi."); }
  };
  const __btnSaveNotificationSettings = $("btnSaveNotificationSettings");
  if(__btnSaveNotificationSettings) __btnSaveNotificationSettings.onclick = async ()=>{
    try{
      setMsg($("notificationSettingsMsg"), "");
      const d = await api("dm_privacy_update","POST",{dm_privacy: __dmPrivacySelect?.value || (u.dm_privacy || "everyone"), dm_sidebar_alerts_enabled: __dmSidebarAlertsEnabled?.checked ? 1 : 0, admin_call_allowed: __adminCallAllowed?.checked ? 1 : 0});
      setMe(d.user); selectedUser = d.user;
      setMsg($("notificationSettingsMsg"), "✅ Kaydedildi.");
    }catch(e){ setMsg($("notificationSettingsMsg"), e.message || "Kaydedilemedi."); }
  };
  const __btnSaveAdminCallSettings = $("btnSaveAdminCallSettings");
  if(__btnSaveAdminCallSettings) __btnSaveAdminCallSettings.onclick = async ()=>{
    try{
      setMsg($("adminCallSettingsMsg"), "");
      const d = await api("dm_privacy_update","POST",{dm_privacy: __dmPrivacySelect?.value || (u.dm_privacy || "everyone"), dm_sidebar_alerts_enabled: __dmSidebarAlertsEnabled?.checked ? 1 : 0, admin_call_allowed: __adminCallAllowed?.checked ? 1 : 0});
      setMe(d.user); selectedUser = d.user;
      setMsg($("adminCallSettingsMsg"), "✅ Kaydedildi.");
    }catch(e){ setMsg($("adminCallSettingsMsg"), e.message || "Kaydedilemedi."); }
  };
  const __accountPrivacySelect = $("accountPrivacySelect");
  if(__accountPrivacySelect) __accountPrivacySelect.value = u.account_privacy || "private";
  const __btnSaveAccountPrivacy = $("btnSaveAccountPrivacy");
  if(__btnSaveAccountPrivacy) __btnSaveAccountPrivacy.onclick = async ()=>{
    try{
      setMsg($("accountPrivacyMsg"), "");
      const d = await api("account_privacy_update","POST",{account_privacy: __accountPrivacySelect.value});
      setMe(d.user); selectedUser = d.user;
      setMsg($("accountPrivacyMsg"), "✅ Kaydedildi.");
    }catch(e){ setMsg($("accountPrivacyMsg"), e.message || "Kaydedilemedi."); }
  };
  const __profileViewsPrivacySelect = $("profileViewsPrivacySelect");
  if(__profileViewsPrivacySelect) __profileViewsPrivacySelect.value = u.profile_views_visibility || "private";
  const __btnSaveProfileViewsPrivacy = $("btnSaveProfileViewsPrivacy");
  if(__btnSaveProfileViewsPrivacy) __btnSaveProfileViewsPrivacy.onclick = async ()=>{
    try{
      setMsg($("profileViewsPrivacyMsg"), "");
      const d = await api("profile_views_visibility_update","POST",{profile_views_visibility: __profileViewsPrivacySelect.value});
      setMe(d.user); selectedUser = d.user;
      setMsg($("profileViewsPrivacyMsg"), "✅ Kaydedildi.");
      await selectUser(me.id);
    }catch(e){ setMsg($("profileViewsPrivacyMsg"), e.message || "Kaydedilemedi."); }
  };
  loadBlockedUsers().catch(()=>{});
  loadMyReports().catch(()=>{});
  loadBadgeRequestStatus().catch(()=>{});
  const __btnSendBadgeRequest = $("btnSendBadgeRequest");
  if(__btnSendBadgeRequest) __btnSendBadgeRequest.onclick = sendBadgeRequest;

  const editYear = $("editYear");
  const already = !!u.grad_year;
  if(already){
    editYear.disabled = true;
    editYear.title = t('yearLockHint');
  }else{
    const until = Number(localStorage.getItem(GRAD_LOCK_KEY) || "0");
    if(until && Date.now() < until){
      editYear.disabled = true;
      editYear.title = "1 dakika bekleyin.";
      setTimeout(()=>{ editYear.disabled = false; }, (until-Date.now())+50);
    }
    editYear.onchange = ()=>{
      const until2 = Number(localStorage.getItem(GRAD_LOCK_KEY) || "0");
      if(until2 && Date.now() < until2){
        alert("Mezuniyet yılı için 1 dakika bekle.");
        editYear.value = "";
        return;
      }
      const v = editYear.value.trim();
      if(!v) return;
      const ok = confirm(`Mezuniyet yılını "${v}" olarak kaydetmek istediğine emin misin? Bu işlem 1 kere yapılabilir.`);
      if(!ok){
        localStorage.setItem(GRAD_LOCK_KEY, String(Date.now()+60_000));
        editYear.value = "";
        editYear.disabled = true;
        setTimeout(()=>{ editYear.disabled = false; }, 60_000);
      }
    };
  }

  const __btnClearPhoto = $("btnClearPhoto");
  if(__btnClearPhoto) __btnClearPhoto.onclick = ()=>{
    $("photoFile").value = "";
    setMsg($("photoMsg"), "");
  };

  const __btnUploadPhoto = $("btnUploadPhoto");
  if(__btnUploadPhoto) __btnUploadPhoto.onclick = async ()=>{
    try{
      setMsg($("photoMsg"),"");
      const f = $("photoFile").files[0];
      if(!f) throw new Error(t("photoRequired"));
      const form = new FormData();
      form.append("photo", f);
      const d = await api("upload_photo","POST",form,true);
      setMe(d.user);
      $("photoFile").value = "";
      setMsg($("photoMsg"),t("uploaded"));
      await selectUser(me.id);
    }catch(e){ setMsg($("photoMsg"), e.message); }
  };

  const __btnUploadCover = $("btnUploadCover");
  if(__btnUploadCover) __btnUploadCover.onclick = async ()=>{
    try{
      setMsg($("coverMsg"),"");
      const f = $("coverPhotoFile").files && $("coverPhotoFile").files[0] ? $("coverPhotoFile").files[0] : null;
      if(!f) throw new Error("Kapak fotoğrafı seç.");
      const form = new FormData();
      form.append("photo", f);
      const d = await api("upload_cover_photo","POST",form,true);
      setMe(d.user);
      selectedUser = d.user;
      $("coverPhotoFile").value = "";
      setMsg($("coverMsg"),"✅ Kapak yüklendi.");
      profileHeader.innerHTML = profileHeaderHtml(selectedUser);
      renderProfilePanel(selectedUser);
    }catch(e){ setMsg($("coverMsg"), e.message); }
  };

  const __btnSharePhoto = $("btnSharePhoto");
  if(__btnSharePhoto) __btnSharePhoto.onclick = async ()=>{
    try{
      setMsg($("postMsg"),"");
      const file = $("postPhoto").files && $("postPhoto").files[0] ? $("postPhoto").files[0] : null;
      if(!file) throw new Error(t("photoRequired"));
      const fd = new FormData();
      fd.append("caption", $("postCaption").value.trim());
      fd.append("photo", file);
      await api("photo_post_create","POST",fd,true);
      $("postCaption").value=""; $("postPhoto").value="";
      setMsg($("postMsg"),t("uploaded"));
      await selectUser(u.id);
      setProfileMiniTab('gallery');
      await renderPhotoPosts(u.id, true);
    }catch(e){ setMsg($("postMsg"), e.message); }
  };

  const __btnSaveProfile = $("btnSaveProfile");
  if(__btnSaveProfile) __btnSaveProfile.onclick = async ()=>{
    try{
      setMsg($("saveMsg"),"");
      const payload = {
        full_name: $("editName").value.trim(),
        school: $("editSchool").value.trim(),
        class_label: $("editClass")?.value?.trim() || $("editClassInline")?.value?.trim() || "",
        grad_year: $("editYear").value.trim(),
        instagram: $("editIg").value.trim(),
        phone: $("editPhone").value.trim(),
        bio: $("editBio").value.trim(),
        profile_music_platform: $("editMusicPlatform").value,
        profile_music_url: $("editMusicUrl").value.trim(),
        city: $("editCity")?.value?.trim() || '',
        current_stage: $("editStage")?.value || '',
        profile_views_visibility: $("profileViewsPrivacySelect")?.value || (u.profile_views_visibility || 'private'),
        dm_sidebar_alerts_enabled: $("dmSidebarAlertsEnabled")?.checked ? 1 : 0,
      };
      const d = await api("update_profile","PUT",payload);
      setMe(d.user);
      selectedUser = d.user;
      setMsg($("saveMsg"),t("saved"));
      profileHeader.innerHTML = profileHeaderHtml(selectedUser);
      renderProfilePanel(selectedUser);
      if(typeof enhanceProfilePremium === "function") await enhanceProfilePremium(selectedUser);
      await updateFollowCounts(selectedUser.id);
      await loadUsers();
    }catch(e){ setMsg($("saveMsg"), e.message); }
  };

  document.querySelectorAll('[data-profilemini]').forEach(btn=>btn.onclick=()=>setProfileMiniTab(btn.dataset.profilemini));
  const heroEdit = $('btnHeroEditProfile'); if(heroEdit) heroEdit.onclick = ()=>setProfileMiniTab('edit');
  const heroShare = $('btnHeroShareTab'); if(heroShare) heroShare.onclick = ()=>setProfileMiniTab('share');
  const heroGallery = $('btnHeroGalleryTab'); if(heroGallery) heroGallery.onclick = ()=>setProfileMiniTab('gallery');
  const heroDm = $('btnHeroDM'); if(heroDm) heroDm.onclick = ()=>btnDM.click();
  const heroCover = $('btnHeroCoverTab'); if(heroCover) heroCover.onclick = ()=>setProfileMiniTab('edit');
  const openGalleryBtn = $('btnOpenGalleryTab'); if(openGalleryBtn) openGalleryBtn.onclick = ()=>setProfileMiniTab('gallery');
  setProfileMiniTab('edit');
  renderPhotoPosts(u.id, true);
}


function setProfileMiniTab(name){
  document.querySelectorAll('[data-profilemini]').forEach(btn=>btn.classList.toggle('active', btn.dataset.profilemini===name));
  document.querySelectorAll('.profileMiniPanel').forEach(p=>p.classList.toggle('hidden', p.dataset.profilepanel!==name));
}

function buildPhotoCommentsHtml(comments, isMe, postId){
  return comments.length ? comments.map(c=>`
    <div class="photoCommentItem">
      <div style="display:flex;gap:8px;align-items:flex-start">
        ${avatarHtml({full_name:c.full_name, photo_url:c.photo_url})}
        <div style="min-width:0;flex:1">
          <div class="photoCommentHead"><b>${escapeHtml(c.full_name||'')}</b><span>${new Date(String(c.created_at).replace(" ","T")+"Z").toLocaleString()}</span></div>
          <div class="photoCommentBody">${c.deleted_at ? '[silindi]' : escapeHtml(c.body||'')}</div>
        </div>
        ${isMe || (me && Number(me.id)===Number(c.user_id)) ? `<button class="btn" data-delcomment="${c.id}" data-post="${postId}">${t('deleteComment')}</button>` : ``}
      </div>
    </div>`).join('') : `<div class="muted small">${t('comments')}: 0</div>`;
}

function buildPhotoDetailHtml(p, isMe){
  const comments = Array.isArray(p.comments) ? p.comments : [];
  const commentsHtml = buildPhotoCommentsHtml(comments, isMe, p.id);
  return `
    <div class="photoDetail">
      <div class="photoDetailMediaWrap">
        <img src="${escapeHtml(resolveUrl(p.image_url))}" alt="photo" class="photoDetailImg" data-likephoto="${p.id}"/>
        <div class="photoDoubleLike ${p.my_liked ? 'show' : ''}" id="photoDoubleLike">♥</div>
      </div>
      <div class="photoDetailSide">
        <div class="photoCardHead">
          <div style="display:flex;gap:10px;align-items:center;min-width:0">
            ${avatarHtml({full_name:p.full_name, photo_url:p.user_photo_url})}
            <div class="userMeta">
              <div class="userName">${escapeHtml(p.full_name||'')}</div>
              <div class="photoMeta">${new Date(String(p.created_at).replace(" ","T")+"Z").toLocaleString()}</div>
            </div>
          </div>
          ${isMe ? `<div class="photoDetailTopActions"><button class="btn" data-pinphoto="${p.id}">${p.pinned ? 'Sabitlemeyi Kaldır' : 'Sabitle'}</button><button class="btn" data-editphoto="${p.id}">Düzenle</button><button class="btn danger" data-delphoto="${p.id}">${t('deletePhoto')}</button></div>` : ``}
        </div>
        ${p.caption ? `<div class="photoCaption">${escapeHtml(p.caption||'')}</div>` : ``}
        <div class="photoActionsRow">
          <button class="btn ${p.my_liked ? 'primary' : ''}" data-likephoto="${p.id}">♥ ${t('like')} (${Number(p.likes_count||0)})</button>
          <span class="badge">💬 ${Number(p.comments_count||comments.length)}</span>
        </div>
        <div class="photoCommentsWrap">${commentsHtml}</div>
        <div class="photoCommentForm">
          <input class="input" id="commentInput_${p.id}" placeholder="${t('writeComment')}"/>
          <button class="btn primary" data-addcomment="${p.id}">${t('send')}</button>
        </div>
      </div>
    </div>`;
}

function wirePhotoInteractions(root, userId, isMe){
  if(!root) return;
  root.querySelectorAll('[data-openphoto]').forEach(el=>el.onclick = ()=> openPhotoModal(Number(el.dataset.openphoto), userId, isMe));
  root.querySelectorAll('[data-delphoto]').forEach(btn=>btn.onclick = async ()=>{
    try{ await api('photo_post_delete','POST',{id:Number(btn.dataset.delphoto)}); closePhotoModal(); await renderPhotoPosts(userId, isMe); }
    catch(e){ setMsg(appMsg, e.message); }
  });
  root.querySelectorAll('[data-editphoto]').forEach(btn=>btn.onclick = async (e)=>{
    e.stopPropagation?.();
    const post = currentPhotoPosts.find(x=>Number(x.id)===Number(btn.dataset.editphoto));
    if(!post) return;
    try{ const ok = await promptPhotoEdit(post); if(ok){ await renderPhotoPosts(userId,isMe); if(photoModal && !photoModal.classList.contains('hidden')) await openPhotoModal(post.id,userId,isMe,false); } }catch(err){ setMsg(appMsg, err.message); }
  });
  root.querySelectorAll('[data-pinphoto]').forEach(btn=>btn.onclick = async (e)=>{
    e.stopPropagation?.();
    const pid = Number(btn.dataset.pinphoto);
    const post = currentPhotoPosts.find(x=>Number(x.id)===pid);
    if(!post) return;
    try{ await togglePhotoPin(post); await renderPhotoPosts(userId,isMe); if(photoModal && !photoModal.classList.contains('hidden')) await openPhotoModal(pid,userId,isMe,false); }catch(err){ setMsg(appMsg, err.message); }
  });
  root.querySelectorAll('[data-moveleft]').forEach(btn=>btn.onclick = async (e)=>{ e.stopPropagation?.(); try{ await movePhoto(Number(btn.dataset.moveleft),'left',userId,isMe); }catch(err){ setMsg(appMsg, err.message); } });
  root.querySelectorAll('[data-moveright]').forEach(btn=>btn.onclick = async (e)=>{ e.stopPropagation?.(); try{ await movePhoto(Number(btn.dataset.moveright),'right',userId,isMe); }catch(err){ setMsg(appMsg, err.message); } });
  root.querySelectorAll('[data-likephoto]').forEach(btn=>{
    btn.onclick = async (ev)=>{
      ev.stopPropagation?.();
      try{ await api('photo_post_like_toggle','POST',{post_id:Number(btn.dataset.likephoto)}); await renderPhotoPosts(userId, isMe); if(photoModal && !photoModal.classList.contains('hidden')) await openPhotoModal(Number(btn.dataset.likephoto), userId, isMe, false); }
      catch(e){ setMsg(appMsg, e.message); }
    };
  });
  root.querySelectorAll('.photoPostImg, .photoDetailImg').forEach(img=>{
    img.ondblclick = async (ev)=>{
      const pid = Number(img.dataset.likephoto || img.closest('[data-openphoto]')?.dataset.openphoto || 0);
      if(!pid) return;
      try{
        const post = currentPhotoPosts.find(x=>Number(x.id)===pid);
        if(!post || !post.my_liked) await api('photo_post_like_toggle','POST',{post_id:pid});
        const heart = document.getElementById('photoDoubleLike') || img.parentElement?.querySelector('.photoDoubleLike');
        if(heart){ heart.classList.remove('show'); void heart.offsetWidth; heart.classList.add('show'); setTimeout(()=>heart.classList.remove('show'), 900); }
        await renderPhotoPosts(userId, isMe);
        if(photoModal && !photoModal.classList.contains('hidden')) await openPhotoModal(pid, userId, isMe, false);
      }catch(e){ setMsg(appMsg, e.message); }
    };
  });
  root.querySelectorAll('[data-addcomment]').forEach(btn=>btn.onclick = async ()=>{
    const postId = Number(btn.dataset.addcomment);
    const input = document.getElementById(`commentInput_${postId}`);
    const body = (input?.value||'').trim();
    if(!body) return setMsg(appMsg, t('writeMessageErr'));
    try{ await api('photo_post_comment_create','POST',{post_id:postId, body}); if(input) input.value=''; await renderPhotoPosts(userId, isMe); if(photoModal && !photoModal.classList.contains('hidden')) await openPhotoModal(postId, userId, isMe, false); }
    catch(e){ setMsg(appMsg, e.message); }
  });
  root.querySelectorAll('[data-delcomment]').forEach(btn=>btn.onclick = async ()=>{
    const postId = Number(btn.dataset.post||0);
    try{ await api('photo_post_comment_delete','POST',{comment_id:Number(btn.dataset.delcomment)}); await renderPhotoPosts(userId, isMe); if(photoModal && !photoModal.classList.contains('hidden') && postId) await openPhotoModal(postId, userId, isMe, false); }
    catch(e){ setMsg(appMsg, e.message); }
  });
}

async function openPhotoModal(postId, userId, isMe, unhide=true){
  if(!photoModal || !photoModalBody) return;
  const post = currentPhotoPosts.find(x=>Number(x.id)===Number(postId));
  if(!post) return;
  photoModalBody.innerHTML = buildPhotoDetailHtml(post, isMe);
  if(unhide) photoModal.classList.remove('hidden');
  wirePhotoInteractions(photoModalBody, userId, isMe);
}
function closePhotoModal(){ if(photoModal) photoModal.classList.add('hidden'); }

async function promptPhotoEdit(post){
  const next = prompt('Açıklamayı düzenle:', post.caption || '');
  if(next===null) return false;
  await api('photo_post_update','POST',{id:Number(post.id), caption: next, pinned: post.pinned ? 1 : 0, display_order: Number(post.display_order||0)});
  return true;
}

async function togglePhotoPin(post){
  await api('photo_post_update','POST',{id:Number(post.id), caption: post.caption || '', pinned: post.pinned ? 0 : 1, display_order: Number(post.display_order||0)});
}

async function movePhoto(postId, direction, userId, isMe){
  const ids = currentPhotoPosts.map(x=>Number(x.id));
  const idx = ids.indexOf(Number(postId));
  if(idx<0) return;
  const nextIdx = direction==='left' ? idx-1 : idx+1;
  if(nextIdx<0 || nextIdx>=ids.length) return;
  const temp = ids[idx]; ids[idx]=ids[nextIdx]; ids[nextIdx]=temp;
  await api('photo_post_reorder','POST',{ids});
  await renderPhotoPosts(userId, isMe);
}

async function renderPhotoPosts(userId, isMe){
  const wrap = $("photoPostsWrap");
  if(!wrap) return;
  try{
    const d = await api("photo_posts","GET",{user_id:userId});
    currentPhotoPosts = d.items || [];
    const statPhotos = $('statProfilePhotos');
    if(statPhotos) statPhotos.textContent = String(currentPhotoPosts.length);
    if(!currentPhotoPosts.length){
      wrap.innerHTML = `<p class="muted">${t('noPhotos')}</p>`;
      return;
    }
    wrap.innerHTML = `<div class="photoGridWrap"><div class="photoGridTitleRow"><div class="photoGridTitle">${t('photos')}</div>${isMe ? `<div class="muted small">Sabitle, düzenle ve sola-sağa taşı.</div>`:''}</div><div class="photoGrid instaGrid fixedThree">` + currentPhotoPosts.map((p,idx)=>{
      const comments = Array.isArray(p.comments) ? p.comments : [];
      return `
      <button class="photoTile" data-openphoto="${p.id}" type="button" title="${escapeHtml(p.caption||'')}">
        <img src="${escapeHtml(resolveUrl(p.image_url))}" alt="photo" class="photoPostImg" data-likephoto="${p.id}"/>
        <div class="photoDoubleLike">♥</div>
        <div class="photoTileOverlay">
          <span>♥ ${Number(p.likes_count||0)}</span>
          <span class="commentBadge">💬 ${Number(p.comments_count||comments.length)}</span>
        </div>
        ${p.pinned ? `<div class="photoPinBadge">📌</div>`:''}
        ${p.caption ? `<div class="photoTileCaption">${escapeHtml(p.caption||'')}</div>` : ``}
        ${isMe ? `<div class="photoTileTools" onclick="event.stopPropagation()">
          <button class="photoToolBtn" data-pinphoto="${p.id}" title="Sabitle">📌</button>
          <button class="photoToolBtn" data-editphoto="${p.id}" title="Düzenle">✏️</button>
          <button class="photoToolBtn" data-movephoto="${p.id}" data-dir="left" ${idx===0?'disabled':''} title="Sola taşı">←</button>
          <button class="photoToolBtn" data-movephoto="${p.id}" data-dir="right" ${idx===currentPhotoPosts.length-1?'disabled':''} title="Sağa taşı">→</button>
        </div>`:''}
      </button>`;
    }).join('') + `</div></div>`;
    wirePhotoInteractions(wrap, userId, isMe);
    if(isMe){
      wrap.querySelectorAll('[data-editphoto]').forEach(btn=>btn.onclick = async (e)=>{ e.stopPropagation(); const post=currentPhotoPosts.find(x=>Number(x.id)===Number(btn.dataset.editphoto)); if(!post) return; try{ const ok=await promptPhotoEdit(post); if(ok) await renderPhotoPosts(userId,isMe); }catch(err){ setMsg(appMsg, err.message); } });
      wrap.querySelectorAll('[data-pinphoto]').forEach(btn=>btn.onclick = async (e)=>{ e.stopPropagation(); const post=currentPhotoPosts.find(x=>Number(x.id)===Number(btn.dataset.pinphoto)); if(!post) return; try{ await togglePhotoPin(post); await renderPhotoPosts(userId,isMe); }catch(err){ setMsg(appMsg, err.message); } });
      wrap.querySelectorAll('[data-movephoto]').forEach(btn=>btn.onclick = async (e)=>{ e.stopPropagation(); try{ await movePhoto(Number(btn.dataset.movephoto), btn.dataset.dir, userId, isMe); }catch(err){ setMsg(appMsg, err.message); } });
    }
  }catch(e){
    const statPhotos = $('statProfilePhotos');
    if(statPhotos) statPhotos.textContent = '-';
    wrap.innerHTML = `<p class="muted">${escapeHtml(e.message||'Hata')}</p>`;
  }
}

function renderFarewellsPanel(farewells){
  panelFarewells.innerHTML = "";
  if(!farewells || farewells.length===0){
    panelFarewells.innerHTML = `<p class="muted">Henüz veda mesajı yok.</p>`;
    return;
  }
  farewells.forEach(x=>{
    const dt = new Date(String(x.created_at).replace(" ", "T") + "Z");
    panelFarewells.innerHTML += `
      <div class="fw">
        <div class="fwHead">
          <span>✍️ ${escapeHtml(x.from_name)}</span>
          <span class="muted small">${dt.toLocaleString()}</span>
        </div>
        <div style="white-space:pre-wrap;margin-top:6px">${escapeHtml(x.message)}</div>
        ${x.music_url ? `<div class="muted small" style="margin-top:6px">🎵 ${escapeHtml(x.music_platform || "")} • <a href="${escapeHtml(x.music_url)}" target="_blank" rel="noreferrer">Şarkı linki</a></div>` : ``}
        ${x.reply ? `<div class="fw" style="margin-top:8px;background:rgba(124,58,237,0.10)"><b>Yanıt:</b> ${escapeHtml(x.reply)}</div>` : ``}
      </div>
    `;
  });
}

async function loadMyInbox(){
  const inbox = await api("received_farewells","GET",{sort:"desc"});
  const reqs = await api("follow_requests_inbox");
  const sentReqs = await api("follow_requests_sent");
  renderInboxPanel(inbox.items || [], reqs.items || [], sentReqs.items || []);
}

function renderInboxPanel(items, requests = [], sentRequests = []){
  panelInbox.innerHTML = "";
  if((!items || items.length===0) && (!requests || requests.length===0) && (!sentRequests || sentRequests.length===0)){
    panelInbox.innerHTML = `<p class="muted">Henüz sana gelen bir veda mesajı veya takip isteği yok.</p>`;
    return;
  }

  const sortBox = document.createElement("div");
  sortBox.innerHTML = `
    <div class="row" style="grid-template-columns:1fr 1fr;align-items:end">
      <div>
        <div class="muted small">Sırala</div>
        <select class="input" id="inboxSort">
          <option value="desc">En yeni → En eski</option>
          <option value="asc">En eski → En yeni</option>
        </select>
      </div>
      <div style="display:flex;justify-content:flex-end">
        <button class="btn" id="btnReloadInbox">Yenile</button>
      </div>
    </div>
  `;
  panelInbox.appendChild(sortBox);

  const list = document.createElement("div");
  panelInbox.appendChild(list);

  const requestTabs = document.createElement("div");
  requestTabs.className = 'requestTabs';
  requestTabs.innerHTML = `
    <button class="btn primary" id="btnReqTabIncoming">Gelen İstekler (${requests.length})</button>
    <button class="btn" id="btnReqTabSent">Gönderilen İstekler (${sentRequests.length})</button>
  `;
  panelInbox.appendChild(requestTabs);

  const reqPanels = document.createElement('div');
  reqPanels.innerHTML = `<div id="incomingReqPanel"></div><div id="sentReqPanel" class="hidden"></div>`;
  panelInbox.appendChild(reqPanels);
  const incomingReqPanel = reqPanels.querySelector('#incomingReqPanel');
  const sentReqPanel = reqPanels.querySelector('#sentReqPanel');
  const renderRequestPanels = ()=>{
    incomingReqPanel.innerHTML = '';
    sentReqPanel.innerHTML = '';

    if(requests && requests.length){
      const reqWrap = document.createElement("div");
      reqWrap.innerHTML = `<div class="muted small" style="margin:14px 0 8px">Gelen Takip İstekleri</div>`;
      reqWrap.innerHTML += requests.map(r=>`
        <div class="fw">
          <div class="fwHead"><span>👤 ${escapeHtml(r.from_user.full_name)}</span><span class="muted small">${new Date(String(r.created_at).replace(" ","T")+"Z").toLocaleString()}</span></div>
          <div class="muted small" style="margin-top:6px">${escapeHtml(r.from_user.school||"—")} • ${r.from_user.grad_year||"—"}</div>
          <div class="fwActions">
            <button class="btn primary" data-reqaccept="${r.request_id}" data-uid="${r.from_user.id}">${t("accept")}</button>
            <button class="btn" data-reqreject="${r.request_id}" data-uid="${r.from_user.id}">${t("reject")}</button>
            <button class="btn" data-openprofile="${r.from_user.id}">Profili Aç</button>
          </div>
        </div>
      `).join('');
      incomingReqPanel.appendChild(reqWrap);
    }else{
      incomingReqPanel.innerHTML = `<p class="muted" style="margin-top:12px">Gelen takip isteği yok.</p>`;
    }

    if(sentRequests && sentRequests.length){
      const sentWrap = document.createElement("div");
      sentWrap.innerHTML = `<div class="muted small" style="margin:14px 0 8px">Gönderilen Takip İstekleri</div>`;
      sentWrap.innerHTML += sentRequests.map(r=>`
        <div class="fw">
          <div class="fwHead"><span>📤 ${escapeHtml(r.to_user.full_name)}</span><span class="muted small">${new Date(String(r.created_at).replace(" ","T")+"Z").toLocaleString()}</span></div>
          <div class="muted small" style="margin-top:6px">${escapeHtml(r.to_user.school||"—")} • ${r.to_user.grad_year||"—"}</div>
          <div class="fwActions">
            <button class="btn" data-openprofile="${r.to_user.id}">Profili Aç</button>
            <button class="btn" data-cancelreq="${r.to_user.id}">İsteği Geri Çek</button>
          </div>
        </div>
      `).join('');
      sentReqPanel.appendChild(sentWrap);
    }else{
      sentReqPanel.innerHTML = `<p class="muted" style="margin-top:12px">Gönderilmiş bekleyen istek yok.</p>`;
    }
  };
  renderRequestPanels();

  const EMOJIS = ["👍","❤️","😂","😢","🎉","🔥"];

  const render = ()=>{
    list.innerHTML = "";
    items.forEach(x=>{
      const dt = new Date(String(x.created_at).replace(" ", "T") + "Z");
      const reactions = x.reactions || {};
      const my = new Set(x.my_reactions || []);
      const btns = EMOJIS.map(e=>{
        const c = Number(reactions[e] || 0);
        const active = my.has(e) ? "active" : "";
        const label = c>0 ? `${e} ${c}` : e;
        return `<button class="btn emoji ${active}" data-react="${x.id}" data-emoji="${e}">${label}</button>`;
      }).join("");
      list.innerHTML += `
        <div class="fw">
          <div class="fwHead">
            <span>✍️ ${escapeHtml(x.from_name)}</span>
            <span class="muted small">${dt.toLocaleString()}</span>
          </div>
          <div style="white-space:pre-wrap;margin-top:6px">${escapeHtml(x.message)}</div>
          ${x.music_url ? `<div class="muted small" style="margin-top:6px">🎵 ${escapeHtml(x.music_platform || "")} • <a href="${escapeHtml(x.music_url)}" target="_blank" rel="noreferrer">Şarkı linki</a></div>` : ``}
          ${x.reply ? `<div class="fw" style="margin-top:8px;background:rgba(124,58,237,0.10)"><b>Yanıtın:</b> ${escapeHtml(x.reply)}</div>` : ``}
          <div class="fwActions">${btns}<button class="btn" data-reply="${x.id}">Yanıtla</button></div>
        </div>
      `;
    });

    list.querySelectorAll("button[data-react]").forEach(btn=>{
      btn.onclick = async ()=>{
        try{
          await api("react_farewell","POST",{id:Number(btn.dataset.react), emoji: btn.dataset.emoji});
          const d = await api("received_farewells","GET",{sort: $("inboxSort").value});
          items = d.items || [];
          render();
        }catch(e){ setMsg(appMsg, e.message); }
      };
    });

    list.querySelectorAll("button[data-reply]").forEach(btn=>{
      btn.onclick = async ()=>{
        const id = Number(btn.dataset.reply);
        const reply = prompt("Kısa bir yanıt yaz:", "");
        if(!reply) return;
        try{
          await api("reply_farewell","POST",{id, reply});
          const d = await api("received_farewells","GET",{sort: $("inboxSort").value});
          items = d.items || [];
          render();
        }catch(e){ setMsg(appMsg, e.message); }
      };
    });
  };

  const __btnReloadInbox = $("btnReloadInbox"); if(__btnReloadInbox) __btnReloadInbox.onclick = async ()=>{
    try{
      const d = await api("received_farewells","GET",{sort: $("inboxSort").value});
      items = d.items || [];
      render();
    }catch(e){ setMsg(appMsg, e.message); }
  };

  $("inboxSort").onchange = $("btnReloadInbox").onclick;
  const btnReqTabIncoming = $('btnReqTabIncoming');
  const btnReqTabSent = $('btnReqTabSent');
  if(btnReqTabIncoming) btnReqTabIncoming.onclick = ()=>{
    incomingReqPanel.classList.remove('hidden');
    sentReqPanel.classList.add('hidden');
    btnReqTabIncoming.classList.add('primary');
    btnReqTabSent?.classList.remove('primary');
  };
  if(btnReqTabSent) btnReqTabSent.onclick = ()=>{
    sentReqPanel.classList.remove('hidden');
    incomingReqPanel.classList.add('hidden');
    btnReqTabSent.classList.add('primary');
    btnReqTabIncoming?.classList.remove('primary');
  };
  panelInbox.querySelectorAll("[data-reqaccept]").forEach(btn=>btn.onclick = async ()=>{
    await api("follow_request_respond","POST",{request_id:Number(btn.dataset.reqaccept), decision:'accept'});
    await loadMyInbox();
  });
  panelInbox.querySelectorAll("[data-reqreject]").forEach(btn=>btn.onclick = async ()=>{
    await api("follow_request_respond","POST",{request_id:Number(btn.dataset.reqreject), decision:'reject'});
    await loadMyInbox();
  });
  panelInbox.querySelectorAll("[data-cancelreq]").forEach(btn=>btn.onclick = async ()=>{
    await api('follow_toggle','POST',{user_id:Number(btn.dataset.cancelreq)});
    await loadMyInbox();
  });
  panelInbox.querySelectorAll("[data-openprofile]").forEach(btn=>btn.onclick = async ()=>{ await selectUser(Number(btn.dataset.openprofile)); });

  render();
}

function renderSentPanel(items){
  panelSent.innerHTML = "";
  if(!items || items.length===0){
    panelSent.innerHTML = `<p class="muted">Henüz kimseye veda mesajı göndermemişsin.</p>`;
    return;
  }
  items.forEach(x=>{
    const dt = new Date(String(x.created_at).replace(" ", "T") + "Z");
    panelSent.innerHTML += `
      <div class="fw">
        <div class="fwHead">
          <span>➡️ ${escapeHtml(x.to_name)}</span>
          <span class="muted small">${dt.toLocaleString()}</span>
        </div>
        <div data-sentbody="${x.id}" style="white-space:pre-wrap;margin-top:6px">${escapeHtml(x.message)}</div>
        ${x.music_url ? `<div class="muted small" style="margin-top:6px">🎵 ${escapeHtml(x.music_platform || "")} • <a href="${escapeHtml(x.music_url)}" target="_blank" rel="noreferrer">Şarkı linki</a></div>` : ``}
        <div class="fwActions">
          <button class="btn" data-edit="${x.id}">Düzenle</button>
          <button class="btn danger" data-del="${x.id}">Sil</button>
        </div>
      </div>
    `;
  });

  panelSent.querySelectorAll("button[data-edit]").forEach(btn=>{
    btn.onclick = async ()=>{
      const id = Number(btn.dataset.edit);
      const body = panelSent.querySelector(`[data-sentbody="${id}"]`);
      const current = body ? body.textContent : "";
      const next = prompt("Mesajı düzenle:", current || "");
      if(!next) return;
      try{
        await api("update_farewell","PUT",{id, message: next});
        await selectUser(me.id);
        setTab("sent");
      }catch(e){ setMsg(appMsg, e.message); }
    };
  });
  panelSent.querySelectorAll("button[data-del]").forEach(btn=>{
    btn.onclick = async ()=>{
      const id = Number(btn.dataset.del);
      if(!confirm("Silmek istiyor musun?")) return;
      try{
        await api("delete_farewell","POST",{id});
        await selectUser(me.id);
        setTab("sent");
      }catch(e){ setMsg(appMsg, e.message); }
    };
  });
}

async function selectUser(id){
  if(!suppressNavPush){
    if(currentView === "profile" && selectedUser && Number(selectedUser.id||0)!==Number(id||0)){
      pushNavState({type:"profile", userId:Number(selectedUser.id)});
    }else if(currentView !== "profile"){
      pushNavState({type:"view", view: currentView || "directory"});
    }
  }
  setMsg(appMsg,"");
  const d = await api("user","GET",{id});
  selectedUser = d.user;
  currentProfileMode = (me && selectedUser && me.id === selectedUser.id) ? "my" : "other";

  // record view if other
  if(me && selectedUser && me.id !== selectedUser.id){
    api("record_view","POST",{viewed_id:selectedUser.id}).catch(()=>{});
  }

  // header
  profileHeader.innerHTML = profileHeaderHtml(selectedUser);
  updateFollowCounts(selectedUser.id);
  if(me && selectedUser && me.id===selectedUser.id) refreshProfileBadges();
  if(me && selectedUser && me.id !== selectedUser.id){
    updateFollowControls(selectedUser.id);
  }

  const canSeeViewers = !!(d.can_view_profile_viewers || (me && selectedUser && (me.id===selectedUser.id || me.is_admin===1 || selectedUser.profile_views_visibility==='public')));
  viewsBadge.textContent = canSeeViewers ? `👁 ${d.views_count ?? 0}` : `👁 Gizli`;
  const statViews = $('statProfileViews');
  if(statViews) statViews.textContent = canSeeViewers ? String(d.views_count ?? 0) : 'Gizli';

  // viewer list is shown based on the profile owner's privacy setting
  btnViewers.classList.toggle("hidden", !canSeeViewers);

  // tabs visibility
  tabInbox.classList.toggle("hidden", currentProfileMode!=="my");
  tabSent.classList.toggle("hidden", currentProfileMode!=="my");

  // render panels
  renderProfilePanel(selectedUser);
  if(typeof loadProfilePets === 'function') loadProfilePets(selectedUser.id);
  if(typeof enhanceProfilePremium === "function") enhanceProfilePremium(selectedUser).catch(()=>{});
  applyLanguage();
  renderFarewellsPanel(d.farewells || []);
  renderSentPanel(d.sent_farewells || []);

  if(currentProfileMode==="my"){
    await loadMyInbox();
  }else{
    panelInbox.innerHTML = `<p class="muted">Sadece kendi hesabında gelen vedalar görünür.</p>`;
  }

  setTab("profile");
  switchView("profile");
}

async function openViewers(){
  if(!selectedUser || !me) return;
  try{
    viewersList.innerHTML = `<p class="muted">Yükleniyor...</p>`;
    viewersModal.classList.remove("hidden");
    const d = await api("viewers_list","POST",{viewed_id:selectedUser.id});
    if(!d.items || d.items.length===0){
      viewersList.innerHTML = `<p class="muted">Henüz kimse profilini ziyaret etmemiş.</p>`;
      return;
    }
    viewersList.innerHTML = d.items.map(v=>{
      const dt = new Date(String(v.last_seen).replace(" ", "T") + "Z");
      return `<div class="userCard" style="cursor:default">
        ${v.photo_url ? `<div class="avatar"><img src="${escapeHtml(resolveUrl(v.photo_url))}"></div>` : `<div class="avatar">${escapeHtml((v.full_name||"?")[0]||"?")}</div>`}
        <div class="userMeta">
          <div class="userName">${escapeHtml(v.full_name)}</div>
          <div class="userSub muted">${escapeHtml(v.school||"—")} • ${v.grad_year||"—"} • ${dt.toLocaleString()}</div>
        </div>
      </div>`;
    }).join("");
  }catch(e){
    viewersList.innerHTML = `<p class="muted">${escapeHtml(e.message)}</p>`;
  }
}

async function loadLegacy(){
  const feed = await api("legacy_feed");
  renderLegacy(feed.messages || []);
  const polls = await api("poll_list");
  renderPolls(polls.polls || []);
}

function renderLegacy(msgs){
  legacyChat.innerHTML = "";
  if(!msgs || msgs.length===0){
    legacyChat.innerHTML = `<p class="muted">Henüz mesaj yok. İlk mesajı sen yaz!</p>`;
    return;
  }
  const items = [...msgs].reverse();
  items.forEach(m=>{
    const dt = new Date(String(m.created_at).replace(" ", "T") + "Z");
    const badge = m.from_year ? ` • ${m.from_year}` : "";
    const isMine = !!(me && Number(me.id||0)===Number(m.user_id||0));
    const ownerActions = isMine ? `
      <div class="fwActions" style="margin-top:10px">
        <button class="btn" data-legacy-edit="${m.id}">Düzenle</button>
        <button class="btn danger" data-legacy-del="${m.id}">Sil</button>
      </div>
    ` : ``;
    legacyChat.innerHTML += `
      <div class="fw">
        <div class="fwHead">
          <span>🧓 ${escapeHtml(m.from_name)}${badge}</span>
          <span class="muted small">${dt.toLocaleString()}</span>
        </div>
        <div style="white-space:pre-wrap;margin-top:6px">${escapeHtml(m.message)}</div>
        ${ownerActions}
      </div>
    `;
  });

  legacyChat.querySelectorAll("button[data-legacy-del]").forEach(btn=>{
    btn.onclick = async ()=>{
      if(!confirm("Bu mesaj silinsin mi?")) return;
      try{
        await api("legacy_delete","POST",{id:Number(btn.dataset.legacyDel)});
        setMsg(legacyMsg,"✅ Mesaj silindi.");
        await loadLegacy();
      }catch(e){ setMsg(legacyMsg,e.message); }
    };
  });

  legacyChat.querySelectorAll("button[data-legacy-edit]").forEach(btn=>{
    btn.onclick = async ()=>{
      const target = items.find(x=>Number(x.id)===Number(btn.dataset.legacyEdit));
      if(!target) return;
      const updated = prompt("Mesajını düzenle", target.message || "");
      if(updated===null) return;
      if(!updated.trim()) return setMsg(legacyMsg,"Mesaj yaz.");
      try{
        await api("legacy_update","POST",{id:Number(btn.dataset.legacyEdit), message: updated.trim()});
        setMsg(legacyMsg,"✅ Mesaj güncellendi.");
        await loadLegacy();
      }catch(e){ setMsg(legacyMsg,e.message); }
    };
  });
}

function renderPolls(polls){
  pollList.innerHTML = "";
  if(!polls || polls.length===0){
    pollList.innerHTML = `<p class="muted">${t('groupNoPolls')}</p>`;
    return;
  }
  polls.forEach(p=>{
    const total = (p.options||[]).reduce((a,x)=>a+Number(x.votes||0),0);
    const opts = (p.options||[]).map(o=>{
      const pct = total>0 ? Math.round((o.votes/total)*100) : 0;
      const voted = (p.my_vote === o.id) ? "primary" : "";
      return `<div class="fw" style="padding:10px">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
          <div>${escapeHtml(o.text)}</div>
          <div class="muted small">${o.votes} oy • %${pct}</div>
        </div>
        <div style="margin-top:8px;display:flex;justify-content:flex-end">
          <button class="btn ${voted}" data-vote="${p.id}" data-opt="${o.id}">${p.my_vote===o.id ? "Seçtin" : "Oy ver"}</button>
        </div>
      </div>`;
    }).join("");
    const ownerActions = p.is_owner ? `
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <button class="btn" data-poll-edit="${p.id}">Düzenle</button>
        <button class="btn danger" data-poll-del="${p.id}">Sil</button>
      </div>
    ` : ``;
    pollList.innerHTML += `
      <div class="fw">
        <div class="fwHead" style="align-items:flex-start;gap:10px">
          <div>
            <div>📊 ${escapeHtml(p.question)}</div>
            <div class="muted small" style="margin-top:4px">${escapeHtml(p.from_name||"")}</div>
          </div>
          ${ownerActions}
        </div>
        <div class="muted small" style="margin-top:6px">Toplam: ${total} oy</div>
        ${p.is_owner ? `<div class="muted small" style="margin-top:6px">Not: Düzenlenince mevcut oylar sıfırlanır.</div>` : ``}
        <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px">${opts}</div>
      </div>
    `;
  });

  pollList.querySelectorAll("button[data-vote]").forEach(btn=>{
    btn.onclick = async ()=>{
      try{
        await api("poll_vote","POST",{poll_id:Number(btn.dataset.vote), option_id:Number(btn.dataset.opt)});
        const polls = await api("poll_list");
        renderPolls(polls.polls||[]);
      }catch(e){ setMsg(pollMsg, e.message); }
    };
  });
  pollList.querySelectorAll("button[data-poll-del]").forEach(btn=>{
    btn.onclick = async ()=>{
      if(!confirm("Bu anket silinsin mi?")) return;
      try{
        await api("poll_delete","POST",{id:Number(btn.dataset.pollDel)});
        const polls = await api("poll_list");
        renderPolls(polls.polls||[]);
        setMsg(pollMsg,"✅ Anket silindi.");
      }catch(e){ setMsg(pollMsg, e.message); }
    };
  });
  pollList.querySelectorAll("button[data-poll-edit]").forEach(btn=>{
    btn.onclick = async ()=>{
      const cardPoll = polls.find(x=>Number(x.id)===Number(btn.dataset.pollEdit));
      if(!cardPoll) return;
      const q = prompt("Anket sorusunu düzenle:", cardPoll.question || "");
      if(q===null) return;
      const currentOpts = (cardPoll.options||[]).map(o=>o.text);
      const joined = prompt(`Seçenekleri | ile ayırarak yaz:
Örnek: Seçenek 1 | Seçenek 2 | Seçenek 3`, currentOpts.join(" | "));
      if(joined===null) return;
      const options = joined.split("|").map(x=>x.trim()).filter(Boolean);
      try{
        await api("poll_update","POST",{id:Number(btn.dataset.pollEdit), question:q.trim(), options});
        const refreshed = await api("poll_list");
        renderPolls(refreshed.polls||[]);
        setMsg(pollMsg,"✅ Anket güncellendi.");
      }catch(e){ setMsg(pollMsg, e.message); }
    };
  });
}

// Core navigation bindings
if(btnLangTR) btnLangTR.onclick = ()=>setLanguage('tr');
if(btnLangEN) btnLangEN.onclick = ()=>setLanguage('en');
if(btnLangTRAuth) btnLangTRAuth.onclick = ()=>setLanguage('tr');
if(btnLangENAuth) btnLangENAuth.onclick = ()=>setLanguage('en');
if(btnCloseFollows) btnCloseFollows.onclick = ()=>{ if(followsModal) followsModal.classList.add('hidden'); };
if(followsModal) followsModal.addEventListener('click', (e)=>{ if(e.target===followsModal) followsModal.classList.add('hidden'); });
if(tabLogin) tabLogin.onclick = ()=>{ tabLogin.classList.add('active'); tabRegister.classList.remove('active'); loginPanel.classList.remove('hidden'); registerPanel.classList.add('hidden'); $('loginEmail')?.focus(); };
if(tabRegister) tabRegister.onclick = ()=>{ tabRegister.classList.add('active'); tabLogin.classList.remove('active'); registerPanel.classList.remove('hidden'); loginPanel.classList.add('hidden'); $('regName')?.focus(); renderPasswordStrength(); };
if(btnMenu) btnMenu.onclick = ()=>openDrawer();
if(btnCloseDrawer) btnCloseDrawer.onclick = ()=>closeDrawer();
if(drawerOverlay) drawerOverlay.onclick = ()=>closeDrawer();
const simpleMenuList = document.querySelector('.simpleMenuList');
bindSimpleMenuNavigation();
bindBlast();
if(btnMyProfile) btnMyProfile.onclick = async ()=>navigateSimpleMenu("profile");
if(btnAbout) btnAbout.onclick = ()=>navigateSimpleMenu("about");
if(btnScene) btnScene.onclick = async ()=>navigateSimpleMenu("scene");
if(btnStyle) btnStyle.onclick = async ()=>navigateSimpleMenu("style");
if(btnBackScene) btnBackScene.onclick = ()=>goBack('dashboard');
if(btnBackStyle) btnBackStyle.onclick = ()=>goBack('dashboard');
if(btnBackAbout) btnBackAbout.onclick = ()=>goBack('dashboard');
if(btnBack) btnBack.onclick = ()=>goBack('dashboard');
if(btnBackPet) btnBackPet.onclick = ()=>goBack('dashboard');
if(btnBackLegacy) btnBackLegacy.onclick = ()=>switchView('dashboard');
if(btnViewers) btnViewers.onclick = ()=>openViewers();
if(viewersModal) viewersModal.addEventListener('click', (e)=>{ if(e.target===viewersModal) viewersModal.classList.add('hidden'); });
if(btnCloseViewers) btnCloseViewers.onclick = ()=>viewersModal.classList.add('hidden');
if(tabProfile) tabProfile.onclick = ()=>setTab('profile');
if(tabInbox) tabInbox.onclick = ()=>setTab('inbox');
if(tabFarewells) tabFarewells.onclick = ()=>setTab('farewells');
if(tabSent) tabSent.onclick = ()=>setTab('sent');

// Tabs / nav
if(btnHome) btnHome.onclick = async ()=>navigateSimpleMenu("dashboard");
if(btnDirectory) btnDirectory.onclick = ()=>navigateSimpleMenu("directory");
if(btnLegacy) btnLegacy.onclick = async ()=>navigateSimpleMenu("legacy");
if(btnGossip) btnGossip.onclick = async ()=>navigateSimpleMenu("gossip");
if(btnBackGossip) btnBackGossip.onclick = ()=>switchView("dashboard");

if(btnDM) btnDM.onclick = async ()=>navigateSimpleMenu("dm");
btnBackDM.onclick = ()=>switchView("dashboard");
if(btnCreateDmGroup) btnCreateDmGroup.onclick = ()=>openDmGroupModal();
if(btnCloseDmGroup) btnCloseDmGroup.onclick = ()=>closeDmGroupModal();
if(dmGroupModal) dmGroupModal.addEventListener('click', (e)=>{ if(e.target===dmGroupModal) closeDmGroupModal(); });
if(dmGroupSearch) dmGroupSearch.addEventListener('input', ()=>renderDmGroupCandidates());
if(btnDmGroupSave) btnDmGroupSave.onclick = async ()=>{
  try{
    const ids = Array.from(dmGroupCandidates?.querySelectorAll('input[type="checkbox"]:checked') || []).map(el=>Number(el.value||0)).filter(Boolean);
    if(ids.length < 2) return setMsg(dmGroupMsg, t('groupNeedMembers'));
    const fd = new FormData();
    fd.append('title', String(dmGroupName?.value || '').trim());
    fd.append('description', String(dmGroupDesc?.value || '').trim());
    fd.append('spotify_link', String(dmGroupSpotify?.value || '').trim());
    fd.append('member_ids', JSON.stringify(ids));
    const file = dmGroupPhoto?.files && dmGroupPhoto.files[0] ? dmGroupPhoto.files[0] : null;
    if(file) fd.append('group_photo', file);
    const created = await api('dm_group_create','POST',fd,true);
    closeDmGroupModal();
    const list = await api('dm_list');
    const items = list.items || [];
    renderDmList(items);
    const thread = items.find(x => (x.thread_kind || 'direct') === 'group' && Number(x.group_id || x.conversation_id || 0) === Number(created.group_id));
    switchView('dm');
    if(thread) await openDmThreadItem(thread, t('groupCreated'));
    else setMsg(dmMsg, t('groupCreated'));
  }catch(err){ setMsg(dmGroupMsg, err.message || 'Hata'); }
};
if(btnMeet) btnMeet.onclick = async ()=>navigateSimpleMenu("meet");
const btnNova = $("btnNova");
const btnBackNova = $("btnBackNova");
if(btnNova) btnNova.onclick = async ()=>navigateSimpleMenu("nova");
bindOrbitInteractions();
syncOrbitToView(currentView || 'dashboard');
if(btnBackNova) btnBackNova.onclick = ()=>switchView('dashboard');
if(btnBackMeet) btnBackMeet.onclick = ()=>switchView("dashboard");
const __tabMeetCoffee = $("tabMeetCoffee"); if(__tabMeetCoffee) __tabMeetCoffee.onclick = ()=>setMeetCategory('coffee');
const __tabMeetPitch = $("tabMeetPitch"); if(__tabMeetPitch) __tabMeetPitch.onclick = ()=>setMeetCategory('pitch');
const __tabMeetOpen = $("tabMeetOpen"); if(__tabMeetOpen) __tabMeetOpen.onclick = ()=>setMeetMode('open');
const __tabMeetSaved = $("tabMeetSaved"); if(__tabMeetSaved) __tabMeetSaved.onclick = ()=>setMeetMode('saved');
const __btnMeetRefresh = $("btnMeetRefresh"); if(__btnMeetRefresh) __btnMeetRefresh.onclick = ()=>loadMeetups();
const __meetFilterProvince = $("meetFilterProvince"); if(__meetFilterProvince) __meetFilterProvince.oninput = ()=>loadMeetups();
const __meetDateInput = $("meetDateInput"); if(__meetDateInput) __meetDateInput.onchange = ()=>{ confirmedMeetDate = ''; if($("meetDatePreview")) $("meetDatePreview").textContent = t('meetDatePending'); };
const __btnConfirmMeetDate = $("btnConfirmMeetDate"); if(__btnConfirmMeetDate) __btnConfirmMeetDate.onclick = ()=>confirmMeetDateSelection();
const __btnCancelMeetEdit = $("btnCancelMeetEdit"); if(__btnCancelMeetEdit) __btnCancelMeetEdit.onclick = ()=>{ resetMeetupForm(); setMsg($("meetMsg"), ''); };
if(btnCloseMeetQuestion) btnCloseMeetQuestion.onclick = ()=>closeMeetQuestionModal();
if(meetQuestionModal) meetQuestionModal.addEventListener('click', (e)=>{ if(e.target===meetQuestionModal) closeMeetQuestionModal(); });
if(btnSendMeetQuestion) btnSendMeetQuestion.onclick = async ()=>{
  try{
    const question_body = meetQuestionText?.value?.trim() || '';
    if(!pendingMeetQuestionId || !question_body) throw new Error(t('meetQuestionEmpty'));
    await api('meetup_question_create','POST',{meetup_id:pendingMeetQuestionId, question_body});
    setMsg(meetQuestionMsg, t('meetQuestionSent'));
    closeMeetQuestionModal();
    setMsg($("meetMsg"), t('meetQuestionSent'));
    await loadMeetups();
  }catch(e){ setMsg(meetQuestionMsg, e.message); }
};
if(btnCloseMeetReview) btnCloseMeetReview.onclick = ()=>closeMeetReviewModal();
if(meetReviewModal) meetReviewModal.addEventListener('click', (e)=>{ if(e.target===meetReviewModal) closeMeetReviewModal(); });
if(meetReviewStars) meetReviewStars.querySelectorAll('[data-star]').forEach(btn=>btn.onclick = ()=>{ pendingMeetReviewStars = Number(btn.dataset.star || 0); paintMeetReviewStars(); });
if(btnSendMeetReview) btnSendMeetReview.onclick = async ()=>{
  try{
    const comment = meetReviewText?.value?.trim() || '';
    if(!pendingMeetReviewId || pendingMeetReviewStars < 1 || pendingMeetReviewStars > 5) throw new Error(t('meetReviewNeedStar'));
    await api('meetup_review_create','POST',{meetup_id:pendingMeetReviewId, rating:pendingMeetReviewStars, comment});
    closeMeetReviewModal();
    setMsg($("meetMsg"), t('meetReviewSaved'));
    await loadMeetups();
  }catch(e){ setMsg(meetReviewMsg, e.message); }
};

async function submitMeetupForm(){
  setMsg($("meetMsg"), '');
  const title = $("meetTitleInput").value.trim();
  const province = $("meetProvinceInput").value.trim();
  const district = $("meetDistrictInput").value.trim();
  const meeting_at = confirmedMeetDate || $("meetDateInput").value;
  const notes = $("meetNoteInput").value.trim();
  const gender_pref = $("meetGenderInput").value || 'any';
  const desired_age = $("meetAgeInput")?.value?.trim() || '';
  const slots_needed = $("meetNeedInput")?.value?.trim() || '';
  const duration_value = $("meetDurationValue")?.value?.trim() || '';
  const duration_unit = $("meetDurationUnit")?.value || 'days';
  const photoFile = $("meetPhotoInput")?.files?.[0] || null;
  if(!title || !province || !meeting_at) throw new Error(lang==='en' ? 'Title, province, and date are required.' : 'Başlık, il ve tarih zorunlu.');
  if(!confirmedMeetDate) throw new Error(t('meetNeedDateConfirm'));
  if(desired_age && (Number(desired_age) < 10 || Number(desired_age) > 99)) throw new Error(lang==='en' ? 'Average age must be between 10 and 99.' : 'Ortalama yaş 10 ile 99 arasında olmalı.');
  if(!duration_value || Number(duration_value) < 1 || Number(duration_value) > 30) throw new Error(t('meetDurationError'));
  if(activeMeetCategory === 'pitch'){
    const n = Number(slots_needed);
    if(!n || n < 1 || n > 30) throw new Error(lang==='en' ? 'Players needed must be between 1 and 30.' : 'Gereken kişi sayısı 1 ile 30 arasında olmalı.');
  }
  const fd = new FormData();
  fd.append('category', activeMeetCategory);
  fd.append('title', title);
  fd.append('province', province);
  fd.append('district', district);
  fd.append('meeting_at', meeting_at);
  fd.append('notes', notes);
  fd.append('gender_pref', gender_pref);
  fd.append('duration_value', String(Number(duration_value)));
  fd.append('duration_unit', duration_unit);
  if(desired_age) fd.append('desired_age', String(Number(desired_age)));
  if(activeMeetCategory === 'pitch' && slots_needed) fd.append('slots_needed', String(Number(slots_needed)));
  if(photoFile) fd.append('photo', photoFile);
  if(editingMeetupId){
    fd.append('id', String(editingMeetupId));
    await api('meetup_update','POST',fd,true);
    setMsg($("meetMsg"), t('meetUpdated'));
  }else{
    await api('meetup_create','POST',fd,true);
    setMsg($("meetMsg"), t('meetupCreated'));
  }
  resetMeetupForm();
  activeMeetMode = 'open';
  const savedTab = $("tabMeetSaved"); const openTab = $("tabMeetOpen");
  if(savedTab) savedTab.classList.remove('active');
  if(openTab) openTab.classList.add('active');
  await loadMeetups();
}
const __btnCreateMeetup = $("btnCreateMeetup"); if(__btnCreateMeetup) __btnCreateMeetup.onclick = async ()=>{ try{ await submitMeetupForm(); }catch(e){ setMsg($("meetMsg"), e.message); } };

function meetGenderText(value){
  const key = value === 'female' ? 'meetGenderFemale' : value === 'male' ? 'meetGenderMale' : value === 'mixed' ? 'meetGenderMixed' : 'meetGenderAny';
  return t(key);
}

function meetTimeBadge(dateStr){
  if(!dateStr) return '';
  const meeting = new Date(String(dateStr).replace(' ','T'));
  if(Number.isNaN(meeting.getTime())) return '';
  const now = new Date();
  const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
  const target = new Date(meeting.getFullYear(), meeting.getMonth(), meeting.getDate());
  const diff = Math.round((target - today) / 86400000);
  if(diff === 0) return t('meetToday');
  if(diff === 1) return t('meetTomorrow');
  if(diff > 1 && diff <= 7) return t('meetThisWeek');
  return '';
}

function meetCardIcon(category){
  return category === 'pitch' ? '⚽' : '☕';
}

function meetVisualPhoto(item){
  return item.meetup_photo_url || item.photo_url || '';
}

function setMeetCategory(cat){
  activeMeetCategory = cat === 'pitch' ? 'pitch' : 'coffee';
  const a = $("tabMeetCoffee"); const b = $("tabMeetPitch");
  if(a) a.classList.toggle('active', activeMeetCategory==='coffee');
  if(b) b.classList.toggle('active', activeMeetCategory==='pitch');
  const needWrap = $("meetNeedWrap");
  if(needWrap) needWrap.classList.toggle('hidden', activeMeetCategory !== 'pitch');
  loadMeetups();
}

function setMeetMode(mode){
  activeMeetMode = mode === 'saved' ? 'saved' : 'open';
  const a = $("tabMeetOpen"); const b = $("tabMeetSaved");
  if(a) a.classList.toggle('active', activeMeetMode==='open');
  if(b) b.classList.toggle('active', activeMeetMode==='saved');
  loadMeetups();
}

function formatMeetDatePreview(value){
  if(!value) return t('meetDateNotConfirmed');
  const d = new Date(String(value).replace(' ','T'));
  if(Number.isNaN(d.getTime())) return t('meetDateNotConfirmed');
  return `${t('meetDateConfirmed')}: ${d.toLocaleString()}`;
}

function confirmMeetDateSelection(){
  const input = $("meetDateInput");
  const preview = $("meetDatePreview");
  confirmedMeetDate = input?.value || '';
  if(preview) preview.textContent = formatMeetDatePreview(confirmedMeetDate);
}

function resetMeetupForm(){
  editingMeetupId = null;
  confirmedMeetDate = '';
  if($("meetTitleInput")) $("meetTitleInput").value='';
  if($("meetProvinceInput")) $("meetProvinceInput").value='';
  if($("meetDistrictInput")) $("meetDistrictInput").value='';
  if($("meetDateInput")) $("meetDateInput").value='';
  if($("meetGenderInput")) $("meetGenderInput").value='any';
  if($("meetAgeInput")) $("meetAgeInput").value='';
  if($("meetNeedInput")) $("meetNeedInput").value='';
  if($("meetDurationValue")) $("meetDurationValue").value='3';
  if($("meetDurationUnit")) $("meetDurationUnit").value='days';
  if($("meetNoteInput")) $("meetNoteInput").value='';
  if($("meetPhotoInput")) $("meetPhotoInput").value='';
  if($("meetDatePreview")) $("meetDatePreview").textContent = t('meetDateNotConfirmed');
  if($("btnCreateMeetup")) $("btnCreateMeetup").textContent = t('meetPublish');
  if($("btnCancelMeetEdit")) $("btnCancelMeetEdit").classList.add('hidden');
}

function startMeetupEdit(item){
  editingMeetupId = Number(item.id);
  if($("meetTitleInput")) $("meetTitleInput").value=item.title || '';
  if($("meetProvinceInput")) $("meetProvinceInput").value=item.province || '';
  if($("meetDistrictInput")) $("meetDistrictInput").value=item.district || '';
  if($("meetDateInput")) $("meetDateInput").value = item.meeting_at ? String(item.meeting_at).replace(' ','T').slice(0,16) : '';
  if($("meetGenderInput")) $("meetGenderInput").value=item.gender_pref || 'any';
  if($("meetAgeInput")) $("meetAgeInput").value=item.desired_age || '';
  if($("meetNeedInput")) $("meetNeedInput").value=item.slots_needed || '';
  if($("meetDurationValue")) $("meetDurationValue").value=item.duration_value || '3';
  if($("meetDurationUnit")) $("meetDurationUnit").value=item.duration_unit || 'days';
  if($("meetNoteInput")) $("meetNoteInput").value=item.notes || '';
  confirmedMeetDate = $("meetDateInput")?.value || '';
  if($("meetDatePreview")) $("meetDatePreview").textContent = formatMeetDatePreview(confirmedMeetDate);
  if($("btnCreateMeetup")) $("btnCreateMeetup").textContent = t('meetUpdate');
  if($("btnCancelMeetEdit")) $("btnCancelMeetEdit").classList.remove('hidden');
  setMeetCategory(item.category === 'pitch' ? 'pitch' : 'coffee');
  setMsg($("meetMsg"), t('meetEditMode'));
  try{ meetCard?.scrollIntoView({behavior:'smooth', block:'start'}); }catch(_){ }
}

function meetDurationText(item){
  const val = Number(item.duration_value || 0);
  if(!val) return '';
  return `${val} ${t(item.duration_unit === 'hours' ? 'meetDurationHours' : 'meetDurationDays')}`;
}

function meetExpiryBadge(item){
  if(!item.expires_at) return '';
  const exp = new Date(String(item.expires_at).replace(' ','T'));
  if(Number.isNaN(exp.getTime())) return '';
  const diffMs = exp.getTime() - Date.now();
  if(diffMs <= 0) return t('meetStatusClosed');
  const hours = Math.ceil(diffMs / 3600000);
  if(hours < 24) return `${hours} ${t('meetDurationHours')} ${t('left').toLowerCase?.() || ''}`.trim();
  const days = Math.ceil(diffMs / 86400000);
  return `${days} ${t('meetDurationDays')} ${t('left').toLowerCase?.() || ''}`.trim();
}

function openMeetQuestionModal(item){
  pendingMeetQuestionId = Number(item.id || 0);
  pendingMeetQuestionTitle = item.title || '';
  if(meetQuestionMeta) meetQuestionMeta.textContent = pendingMeetQuestionTitle;
  if(meetQuestionText) meetQuestionText.value = '';
  setMsg(meetQuestionMsg, '');
  if(meetQuestionModal) meetQuestionModal.classList.remove('hidden');
}

function closeMeetQuestionModal(){
  pendingMeetQuestionId = 0;
  pendingMeetQuestionTitle = '';
  if(meetQuestionModal) meetQuestionModal.classList.add('hidden');
}

function paintMeetReviewStars(){
  meetReviewStars?.querySelectorAll('[data-star]').forEach(btn=>btn.classList.toggle('active', Number(btn.dataset.star) === pendingMeetReviewStars));
}

function openMeetReviewModal(item){
  pendingMeetReviewId = Number(item.id || 0);
  pendingMeetReviewTitle = item.title || '';
  pendingMeetReviewStars = 0;
  if(meetReviewMeta) meetReviewMeta.textContent = pendingMeetReviewTitle;
  if(meetReviewText) meetReviewText.value = '';
  setMsg(meetReviewMsg, '');
  paintMeetReviewStars();
  if(meetReviewModal) meetReviewModal.classList.remove('hidden');
}

function closeMeetReviewModal(){
  pendingMeetReviewId = 0;
  pendingMeetReviewTitle = '';
  pendingMeetReviewStars = 0;
  if(meetReviewModal) meetReviewModal.classList.add('hidden');
}

function meetStatusInfo(item){
  const past = !!(item.meeting_at && (new Date(String(item.meeting_at).replace(' ','T')).getTime() < Date.now()));
  const full = !!item.is_full;
  const closed = item.status === 'closed' || full || past;
  if(full) return { cls:'full', label:t('meetStatusFull') };
  if(closed) return { cls:'closed', label:t('meetStatusClosed') };
  return { cls:'open', label:t('meetStatusOpen') };
}

function meetJoinButtonHtml(item){
  const statusInfo = meetStatusInfo(item);
  const closed = statusInfo.cls !== 'open';
  const mine = !!item.is_mine;
  const req = String(item.my_request_status || 'none');
  if(mine) return '';
  if(req === 'pending') return `<button class="btn meetSaveBtn" data-cancelmeetreq="${item.id}">${t('meetCancelRequest')}</button>`;
  if(req === 'accepted') return `<button class="btn meetSaveBtn active meetActionDisabled" disabled>${t('meetJoinAccepted')}</button>`;
  if(closed) return `<button class="btn meetSaveBtn meetActionDisabled" disabled>${t('meetStatusClosed')}</button>`;
  const label = req === 'rejected' ? t('meetJoinRejected') : t('meetJoin');
  return `<button class="btn primary" data-joinmeet="${item.id}">${label}</button>`;
}

function renderMeetOwnerPanels(data){
  const reqBox = $("meetRequestsBox");
  const attBox = $("meetAttendeesBox");
  const qBox = $("meetQuestionsBox");
  if(!reqBox || !attBox || !qBox) return;
  const groups = Array.isArray(data?.groups) ? data.groups : [];
  if(!groups.length){
    reqBox.innerHTML = `<div class="meetPanelEmpty">${t('meetNoRequests')}</div>`;
    attBox.innerHTML = `<div class="meetPanelEmpty">${t('meetNoAccepted')}</div>`;
    qBox.innerHTML = `<div class="meetPanelEmpty">${t('meetNoQuestions')}</div>`;
    return;
  }
  const reqGroups = groups.filter(g => (g.pending_requests||[]).length);
  const accGroups = groups.filter(g => (g.accepted_requests||[]).length);
  const qGroups = groups.filter(g => (g.questions||[]).length);
  reqBox.innerHTML = reqGroups.length ? reqGroups.map(g=>`
    <div class="meetReqGroup">
      <div class="meetReqHead">
        <div>
          <div class="meetReqTitle">${escapeHtml(g.title||'')}</div>
          <div class="meetReqMeta">
            <span class="tag">📍 ${escapeHtml([g.province||'', g.district||''].filter(Boolean).join(' • ') || '—')}</span>
            <span class="tag">⏳ ${t('meetPendingCount')}: ${Number(g.pending_requests.length||0)}</span>
          </div>
        </div>
        <span class="meetStateBadge ${escapeHtml(meetStatusInfo(g).cls)}">${escapeHtml(meetStatusInfo(g).label)}</span>
      </div>
      ${(g.pending_requests||[]).map(r=>`
        <div class="meetReqItem">
          <div class="meetReqUser">
            ${avatarHtml({full_name:r.full_name, photo_url:r.photo_url})}
            <div class="meetReqUserMeta">
              <div class="meetReqUserName">${escapeHtml(r.full_name||'')}</div>
              <div class="meetReqUserSub">${escapeHtml(r.school||'—')} • ${r.grad_year||'—'}${r.note ? ` • ${escapeHtml(r.note)}` : ''}</div>
            </div>
          </div>
          <div class="meetReqActions">
            <button class="btn" data-openprofile="${r.user_id}">Profil</button>
            <button class="btn primary" data-meetaccept="${r.request_id}">${t('meetRequestAccept')}</button>
            <button class="btn danger" data-meetreject="${r.request_id}">${t('meetRequestReject')}</button>
          </div>
        </div>`).join('')}
    </div>`).join('') : `<div class="meetPanelEmpty">${t('meetNoRequests')}</div>`;

  attBox.innerHTML = accGroups.length ? accGroups.map(g=>`
    <div class="meetReqGroup">
      <div class="meetReqHead">
        <div>
          <div class="meetReqTitle">${escapeHtml(g.title||'')}</div>
          <div class="meetReqMeta">
            <span class="tag">✅ ${t('meetAcceptedCount')}: ${Number(g.accepted_requests.length||0)}</span>
            ${g.slots_needed ? `<span class="tag">🥅 ${t('meetMissingLabel')}: ${Number(g.slots_needed)}</span>` : ''}
            ${g.avg_rating ? `<span class="tag">⭐ ${Number(g.avg_rating).toFixed(1)} (${Number(g.review_count||0)})</span>` : ''}
          </div>
        </div>
        <span class="meetStateBadge ${escapeHtml(meetStatusInfo(g).cls)}">${escapeHtml(meetStatusInfo(g).label)}</span>
      </div>
      ${(g.accepted_requests||[]).map(r=>`
        <div class="meetReqItem">
          <div class="meetReqUser">
            ${avatarHtml({full_name:r.full_name, photo_url:r.photo_url})}
            <div class="meetReqUserMeta">
              <div class="meetReqUserName">${escapeHtml(r.full_name||'')}</div>
              <div class="meetReqUserSub">${escapeHtml(r.school||'—')} • ${r.grad_year||'—'}</div>
            </div>
          </div>
          <div class="meetReqActions">
            <button class="btn" data-openprofile="${r.user_id}">Profil</button>
            <button class="btn" data-dmmeet="${r.user_id}" data-name="${escapeHtml(r.full_name || '')}">${t('meetOpenDm')}</button>
          </div>
        </div>`).join('')}
    </div>`).join('') : `<div class="meetPanelEmpty">${t('meetNoAccepted')}</div>`;

  qBox.innerHTML = qGroups.length ? qGroups.map(g=>`
    <div class="meetReqGroup">
      <div class="meetReqHead">
        <div>
          <div class="meetReqTitle">${escapeHtml(g.title||'')}</div>
          <div class="meetReqMeta">
            <span class="tag">❓ ${(g.questions||[]).length} ${t('questions')}</span>
          </div>
        </div>
        <span class="meetStateBadge ${escapeHtml(meetStatusInfo(g).cls)}">${escapeHtml(meetStatusInfo(g).label)}</span>
      </div>
      ${(g.questions||[]).map(q=>`
        <div class="meetQuestionItem">
          <div class="meetReqUser">
            ${avatarHtml({full_name:q.full_name, photo_url:q.photo_url})}
            <div class="meetReqUserMeta">
              <div class="meetReqUserName">${escapeHtml(q.full_name||'')}</div>
              <div class="meetReqUserSub">${new Date(q.created_at).toLocaleString?.() || escapeHtml(q.created_at || '')}</div>
            </div>
          </div>
          <div class="meetQuestionBody">${escapeHtml(q.question_body || '')}</div>
          ${q.answer_body ? `<div class="meetAnswerBody">↳ ${escapeHtml(q.answer_body)}</div>` : `<div class="meetReqActions" style="margin-top:10px"><button class="btn primary" data-answermeetq="${q.question_id}">${t('meetAnswer')}</button></div>`}
        </div>`).join('')}
    </div>`).join('') : `<div class="meetPanelEmpty">${t('meetNoQuestions')}</div>`;

  [reqBox, attBox, qBox].forEach(box=>{
    box.querySelectorAll('[data-openprofile]').forEach(btn=>btn.onclick = async ()=>{ await selectUser(Number(btn.dataset.openprofile)); });
    box.querySelectorAll('[data-meetaccept]').forEach(btn=>btn.onclick = async ()=>{
      try{
        const d = await api('meetup_request_respond','POST',{request_id:Number(btn.dataset.meetaccept), decision:'accept'});
        setMsg($("meetMsg"), d.full ? t('meetRequestAcceptedOk') + ' • ' + t('meetStatusFull') : t('meetRequestAcceptedOk'));
        await loadMeetups();
      }catch(e){ setMsg($("meetMsg"), e.message); }
    });
    box.querySelectorAll('[data-meetreject]').forEach(btn=>btn.onclick = async ()=>{
      try{
        await api('meetup_request_respond','POST',{request_id:Number(btn.dataset.meetreject), decision:'reject'});
        setMsg($("meetMsg"), t('meetRequestRejectedOk'));
        await loadMeetups();
      }catch(e){ setMsg($("meetMsg"), e.message); }
    });
    box.querySelectorAll('[data-dmmeet]').forEach(btn=>btn.onclick = async ()=>{
      try{ await openDmWithUser(Number(btn.dataset.dmmeet), btn.dataset.name || ''); }catch(e){ setMsg($("meetMsg"), e.message); }
    });
    box.querySelectorAll('[data-answermeetq]').forEach(btn=>btn.onclick = async ()=>{
      const answer = window.prompt(t('meetAnswerPrompt'), '');
      if(answer === null) return;
      try{
        await api('meetup_question_answer','POST',{question_id:Number(btn.dataset.answermeetq), answer_body:String(answer).trim()});
        setMsg($("meetMsg"), t('meetAnswerSaved'));
        await loadMeetups();
      }catch(e){ setMsg($("meetMsg"), e.message); }
    });
  });
}

function renderMeetups(items){
  const el = $("meetList");
  if(!el) return;
  if(!items || !items.length){
    el.innerHTML = `<p class="muted">${t(activeMeetMode === 'saved' ? 'meetSavedEmpty' : 'meetEmpty')}</p>`;
    return;
  }
  el.innerHTML = items.map(item=>{
    const whenDate = item.meeting_at ? new Date(String(item.meeting_at).replace(' ','T')) : null;
    const when = whenDate && !Number.isNaN(whenDate.getTime()) ? whenDate.toLocaleString() : '—';
    const locationBits = [item.province || '', item.district || ''].filter(Boolean);
    const timeBadge = meetTimeBadge(item.meeting_at);
    const visual = meetVisualPhoto(item);
    const cardClass = item.category === 'pitch' ? 'meetItem meetItem--pitch view-enter' : 'meetItem meetItem--coffee view-enter';
    const ownerLine = item.full_name ? `<span class="meetOwnerName">${escapeHtml(item.full_name)}</span>` : '';
    const statusInfo = meetStatusInfo(item);
    const expiryBadge = meetExpiryBadge(item);
    return `
      <div class="${cardClass}">
        <div class="meetItemHero">
          <div class="meetItemMedia">
            ${visual ? `<img src="${escapeHtml(resolveUrl(visual))}" alt="meetup"/>` : `<div class="meetItemMediaFallback">${escapeHtml(meetCardIcon(item.category))}</div>`}
          </div>
          <div class="meetItemHeroBody">
            <div class="meetItemTop">
              <div>
                <div class="meetItemHeaderLine">
                  <span class="meetIconBubble">${escapeHtml(meetCardIcon(item.category))}</span>
                  <div class="meetItemTitle">${escapeHtml(item.title || '')}</div>
                </div>
                <div class="muted small">${t('meetCard' + (item.category === 'pitch' ? 'Pitch' : 'Coffee'))}</div>
              </div>
              <div class="meetBadges">
                <div class="meetItemBadge">${item.category === 'pitch' ? t('meetPitch') : t('meetCoffee')}</div>
                ${timeBadge ? `<div class="meetTimeBadge">${escapeHtml(timeBadge)}</div>` : ''}
                <div class="meetStateBadge ${escapeHtml(statusInfo.cls)}">${escapeHtml(statusInfo.label)}</div>
              </div>
            </div>
            <div class="meetHostRow">
              ${avatarHtml({full_name:item.full_name, photo_url:item.photo_url})}
              <div class="meetHostMeta">
                <span class="meetHostLabel">${t('meetListingOwner')}</span>
                ${ownerLine}
              </div>
              <div class="meetHostTrust"><span class="miniBadge trustBadge">${t('meetTrustLabel')}: ${Number(item.trust_score||0)}</span><span class="miniBadge">${trustTone(Number(item.trust_score||0))}</span></div>
            </div>
            <div class="meetHostCard">
              <div class="meetHostCardTitle">${t('meetHostCardTitle')}</div>
              <div class="meetHostCardStats">
                <span class="tag">⭐ ${item.host_avg_rating ? Number(item.host_avg_rating).toFixed(1) : '—'} (${Number(item.host_review_count||0)})</span>
                <span class="tag">🎯 ${t('meetCompletedHost')}: ${Number(item.completed_total||0)}</span>
                <span class="tag">🗂️ ${t('meetHostedTotal')}: ${Number(item.hosted_total||0)}</span>
              </div>
              <div class="muted small">${t('meetHostExperience')}: ${Number(item.completed_total||0)}</div>
            </div>
          </div>
        </div>
        <div class="meetMinorMeta">
          <span class="tag">📍 ${escapeHtml(locationBits.join(' • ') || '—')}</span>
          <span class="tag">🕒 ${escapeHtml(when)}</span>
          <span class="tag">👥 ${escapeHtml(meetGenderText(item.gender_pref || 'any'))}</span>
          ${item.desired_age ? `<span class="tag">🎂 ~${Number(item.desired_age)}</span>` : ''}
          ${item.category === 'pitch' && item.slots_needed ? `<span class="tag">🥅 ${t('meetMissingLabel')}: ${Number(item.slots_needed)}</span>` : ''}
          ${Number(item.pending_count||0) ? `<span class="tag">⏳ ${t('meetPendingCount')}: ${Number(item.pending_count)}</span>` : ''}
          ${Number(item.accepted_count||0) ? `<span class="tag">✅ ${t('meetAcceptedCount')}: ${Number(item.accepted_count)}</span>` : ''}
          ${item.question_count ? `<span class="meetQuestionCount">❓ ${Number(item.question_count)} ${t('questions')}</span>` : ''}
          ${item.avg_rating ? `<span class="meetRatingPill">⭐ ${Number(item.avg_rating).toFixed(1)} (${Number(item.review_count || 0)})</span>` : ''}
          ${expiryBadge ? `<span class="meetExpirePill">⌛ ${escapeHtml(expiryBadge)}</span>` : ''}
        </div>
        ${item.notes ? `<div class="meetItemNote">${escapeHtml(item.notes)}</div>` : ''}
        <div class="meetActions">
          ${item.is_mine ? `<button class="btn" data-editmeet="${item.id}">${t('meetEdit')}</button><button class="btn danger" data-delmeet="${item.id}">${t('meetDelete')}</button>` : `<button class="btn" data-dmmeet="${item.user_id}" data-name="${escapeHtml(item.full_name || '')}">${t('meetOpenDm')}</button>`}
          ${!item.is_mine ? `<button class="btn" data-askowner="${item.id}">${t('meetAskOwner')}</button>` : ''}
          ${!item.is_mine ? meetJoinButtonHtml(item) : ''}
          ${!item.is_mine ? `<button class="btn meetSaveBtn ${item.is_saved ? 'active' : ''}" data-savemeet="${item.id}">${item.is_saved ? t('meetUnsave') : t('meetSave')}</button>` : ''}
          ${!item.is_mine && item.can_review ? `<button class="btn primary" data-reviewmeet="${item.id}">${t('meetReviewAction')}</button>` : ''}
        </div>
      </div>`;
  }).join('');
  el.querySelectorAll('[data-delmeet]').forEach(btn=>btn.onclick = async ()=>{
    try{
      await api('meetup_delete','POST',{id:Number(btn.dataset.delmeet)});
      if(editingMeetupId === Number(btn.dataset.delmeet)) resetMeetupForm();
      await loadMeetups();
    }catch(e){ setMsg($("meetMsg"), e.message); }
  });
  el.querySelectorAll('[data-editmeet]').forEach(btn=>btn.onclick = ()=>{
    const item = (items||[]).find(x=>Number(x.id)===Number(btn.dataset.editmeet));
    if(item) startMeetupEdit(item);
  });
  el.querySelectorAll('[data-dmmeet]').forEach(btn=>btn.onclick = async ()=>{
    try{
      await openDmWithUser(Number(btn.dataset.dmmeet), btn.dataset.name || '');
    }catch(e){ setMsg($("meetMsg"), e.message); }
  });
  el.querySelectorAll('[data-savemeet]').forEach(btn=>btn.onclick = async ()=>{
    try{
      const d = await api('meetup_save_toggle','POST',{id:Number(btn.dataset.savemeet)});
      setMsg($("meetMsg"), d.saved ? t('meetSavedOk') : t('meetUnsavedOk'));
      await loadMeetups();
    }catch(e){ setMsg($("meetMsg"), e.message); }
  });
  el.querySelectorAll('[data-joinmeet]').forEach(btn=>btn.onclick = async ()=>{
    try{
      const rawNote = window.prompt(t('meetRequestNotePrompt'), '');
      if(rawNote === null) return;
      await api('meetup_request_create','POST',{meetup_id:Number(btn.dataset.joinmeet), note:String(rawNote).trim()});
      setMsg($("meetMsg"), t('meetRequestSentOk'));
      await loadMeetups();
    }catch(e){ setMsg($("meetMsg"), e.message); }
  });
  el.querySelectorAll('[data-cancelmeetreq]').forEach(btn=>btn.onclick = async ()=>{
    try{
      await api('meetup_request_cancel','POST',{meetup_id:Number(btn.dataset.cancelmeetreq)});
      setMsg($("meetMsg"), t('meetRequestCanceledOk'));
      await loadMeetups();
    }catch(e){ setMsg($("meetMsg"), e.message); }
  });
  el.querySelectorAll('[data-askowner]').forEach(btn=>btn.onclick = ()=>{
    const item = (items||[]).find(x=>Number(x.id)===Number(btn.dataset.askowner));
    if(item) openMeetQuestionModal(item);
  });
  el.querySelectorAll('[data-reviewmeet]').forEach(btn=>btn.onclick = ()=>{
    const item = (items||[]).find(x=>Number(x.id)===Number(btn.dataset.reviewmeet));
    if(item) openMeetReviewModal(item);
  });
}

async function loadMeetups(){
  const list = $("meetList");
  if(!list) return;
  try{
    list.innerHTML = `<p class="muted">${t('loading')}</p>`;
    const province = $("meetFilterProvince")?.value?.trim() || '';
    const d = await api('meetups_list','GET',{category:activeMeetCategory, province, mode:activeMeetMode});
    renderMeetups(d.items || []);
    try{
      const ownerPanels = await api('meetup_owner_panels','GET',{category:activeMeetCategory});
      renderMeetOwnerPanels(ownerPanels);
    }catch(_){
      renderMeetOwnerPanels({groups:[]});
    }
    try{
      const hist = await api('meetup_history_list','GET');
      renderMeetHistory(hist.items || []);
    }catch(_){ renderMeetHistory([]); }
  }catch(e){
    list.innerHTML = `<p class="muted">${escapeHtml(e.message || 'Hata')}</p>`;
  }
}


function animateCount(el, nextValue){
  if(!el) return;
  const to = Number(nextValue || 0);
  if(!Number.isFinite(to)){ el.textContent = String(nextValue ?? '0'); return; }
  const from = Number(String(el.textContent || '0').replace(/[^0-9.-]/g,'')) || 0;
  const start = performance.now();
  const duration = 520;
  function frame(now){
    const p = Math.min(1, (now - start) / duration);
    const eased = 1 - Math.pow(1 - p, 3);
    el.textContent = String(Math.round(from + (to - from) * eased));
    if(p < 1) requestAnimationFrame(frame);
  }
  requestAnimationFrame(frame);
}

function dashboardSkeleton(){
  return '<div class="dashboardList">' + Array.from({length:3}).map(()=>'<div class="skeletonCard"></div>').join('') + '</div>';
}

function formatText(template, params={}){
  return String(template || '').replace(/\{(\w+)\}/g, (_, k)=>String(params[k] ?? ''));
}

function relTimeSafe(v){
  try{ return relTimeLabel(v); }catch(_){ return String(v || ''); }
}

function sceneEntryTypeLabel(type){ return t(`sceneTypeLabel_${type || 'scene'}`); }

async function loadDashboard(){
  if(!me || !dashboardCard) return;
  const agenda = $('dashboardAgenda'); const feed = $('dashboardFeed'); const sugg = $('dashboardSuggestions'); const quick = $('dashboardQuickLinks');
  if(agenda) agenda.innerHTML = dashboardSkeleton();
  if(feed) feed.innerHTML = dashboardSkeleton();
  if(sugg) sugg.innerHTML = dashboardSkeleton();
  if(quick) quick.innerHTML = '';
  try{ await refreshProfileBadges(); }catch(_){ }
  const results = await Promise.allSettled([
    api('stats'),
    api('profile_premium_summary','GET',{user_id:me.id}),
    api('legacy_feed'),
    api('meetups_list','GET',{category:'coffee', mode:'open'}),
    api('scene_summary'),
    api('users','GET', me?.school ? {school:me.school} : null),
    api('style_feed','GET',{limit:120}),
    api('my_notifications'),
  ]);
  dashboardCache = {
    stats: results[0].status === 'fulfilled' ? results[0].value : {},
    premium: results[1].status === 'fulfilled' ? (results[1].value.summary || {}) : {},
    legacy: results[2].status === 'fulfilled' ? (results[2].value.messages || []) : [],
    meetups: results[3].status === 'fulfilled' ? (results[3].value.items || []) : [],
    scene: results[4].status === 'fulfilled' ? (results[4].value.summary || {}) : {},
    users: results[5].status === 'fulfilled' ? (results[5].value.users || []) : [],
    style: results[6].status === 'fulfilled' ? (results[6].value.items || []) : [],
    notifications: results[7].status === 'fulfilled' ? (results[7].value.items || []) : [],
  };
  renderDashboard();
}

function styleDiscountPercent(item){
  const before = Number(item?.price_before || 0);
  const now = Number(item?.price_now || 0);
  if(!(before > now && now > 0)) return 0;
  return Math.max(1, Math.round((1 - (now / Math.max(before,1))) * 100));
}
function styleDiscountAmount(item){
  const before = Number(item?.price_before || 0);
  const now = Number(item?.price_now || 0);
  if(!(before > now && now > 0)) return 0;
  return Math.max(0, before - now);
}

function readStylePriceInput(id){
  const raw = String($(id)?.value || '').replace(/\./g,'').replace(',', '.').trim();
  const n = Number(raw);
  return Number.isFinite(n) ? n : 0;
}
function styleNameCompare(a,b){ return String(a||'').trim().toLowerCase() === String(b||'').trim().toLowerCase(); }
function renderStyleDiscountPreview(){
  const field = $('styleDiscountPreviewField');
  const box = $('styleDiscountPreview');
  if(!field || !box) return;
  const isDeal = styleComposeMode === 'deal' || $('stylePostType')?.value === 'deal';
  field.classList.toggle('hidden', !isDeal);
  if(!isDeal) return;
  const now = readStylePriceInput('stylePriceNow');
  const before = readStylePriceInput('stylePriceBefore');
  const pct = before > now && now > 0 ? Math.max(1, Math.round((1 - now / Math.max(before,1)) * 100)) : 0;
  const saving = before > now && now > 0 ? before - now : 0;
  box.innerHTML = pct ? `<div><span>${escapeHtml(t('styleLiveDiscount'))}</span><b>-%${pct}</b></div><div><span>${escapeHtml(t('styleLiveSaving'))}</span><b>${escapeHtml(formatPriceTRY(saving))}</b></div>` : `<div><span>${escapeHtml(t('styleLiveDiscount'))}</span><b>${escapeHtml(t('styleLiveNoDiscount'))}</b></div>`;
}

function styleDealScore(item){
  const pct = styleDiscountPercent(item);
  const engagement = Number(item?.like_count || 0) + Number(item?.save_count || 0);
  return pct * 100 + engagement;
}

function dashboardEmptyActionGrid(items=[]){
  return `<div class="dashboardEmptyGrid">${items.map((item, idx)=>`<article class="dashboardEmptyCard" style="--stagger:${idx*55}ms"><div class="dashboardEmptyIcon">${item.icon || '✨'}</div><div><b>${escapeHtml(item.title || '')}</b><p>${escapeHtml(item.body || '')}</p>${item.view ? `<button class="dashboardEmptyAction" data-home-empty-view="${escapeHtml(item.view)}">${escapeHtml(item.action || t('homeOpen'))}</button>` : ''}</div></article>`).join('')}</div>`;
}

function dashboardMiniPlaybook(icon, title, body, action, view){
  return `<div class="dashboardMiniPlaybook"><div class="dashboardMiniPlaybookIcon">${icon || '✨'}</div><div><b>${escapeHtml(title || '')}</b><p>${escapeHtml(body || '')}</p>${view ? `<button class="dashboardEmptyAction" data-home-empty-view="${escapeHtml(view)}">${escapeHtml(action || t('homeOpen'))}</button>` : ''}</div></div>`;
}

function bindDashboardEmptyActions(root = document){
  root.querySelectorAll('[data-home-empty-view]').forEach(btn=>{
    if(btn.dataset.bound === '1') return;
    btn.dataset.bound = '1';
    btn.addEventListener('click', ()=>navigateSimpleMenu(btn.dataset.homeEmptyView || 'dashboard'));
  });
}

function pickTopOutfitByWindow(items, fromDate){
  const fromTs = fromDate ? new Date(fromDate).getTime() : 0;
  return (items || [])
    .filter(item=>String(item?.post_type || 'outfit') === 'outfit')
    .filter(item=>{
      const ts = new Date(item?.created_at || 0).getTime();
      return Number.isFinite(ts) && ts >= fromTs;
    })
    .sort((a,b)=>{
      const scoreA = Number(a?.like_count || 0) + Number(a?.save_count || 0) * 2;
      const scoreB = Number(b?.like_count || 0) + Number(b?.save_count || 0) * 2;
      if(scoreB !== scoreA) return scoreB - scoreA;
      return new Date(b?.created_at || 0) - new Date(a?.created_at || 0);
    })[0] || null;
}

function renderDashboard(){
  if(!dashboardCard || !me || !dashboardCache) return;
  const d = dashboardCache;
  const greeting = $('dashboardGreeting');
  const heroAvatar = $('dashboardHeroAvatar');
  const statusText = $('dashboardStatusText');
  const heroMeta = $('dashboardHeroMeta');
  const dashboardAlerts = Number((profileBadgeState?.follow_requests || 0) + (profileBadgeState?.dm_unread || 0));
  if(greeting) greeting.textContent = formatText(t('homeGreeting'), {name:(me.full_name || '').split(' ')[0] || me.full_name || 'MEra'});
  if(statusText) statusText.textContent = t('homeStatusReady');
  if(heroAvatar) heroAvatar.innerHTML = avatarHtml(me);
  if(heroMeta){
    const heroChips = [me.school, me.class_label, d.scene?.theme?.title, dashboardAlerts ? `${dashboardAlerts} ${t('homeMiniAlerts')}` : ''].filter(Boolean).slice(0,4);
    heroMeta.innerHTML = heroChips.map((chip, idx)=>`<span class="dashboardHeroChip" style="--stagger:${idx*50}ms">${escapeHtml(String(chip))}</span>`).join('');
  }
  animateCount($('homeStatStreak'), Number(d.premium?.active_area_count || 0));
  animateCount($('homeStatAlerts'), dashboardAlerts);
  animateCount($('homeStatOrbit'), Number(d.premium?.meet_metrics?.hosted_total || 0));

  const agendaItems = [
    {label:t('homeAgendaTopic'), value:(d.legacy[0]?.message || d.scene?.theme?.subtitle || t('homeEmpty'))},
    {label:t('homeAgendaSong'), value:(d.premium?.last_track?.track_url || d.scene?.recent_items?.find(x=>x.entry_type==='soundtrack')?.media_title || t('homeScenePrompt'))},
    {label:t('homeAgendaOrbit'), value:(d.meetups[0]?.title || d.premium?.last_orbit?.title || t('noOrbitYet'))},
    {label:t('homeAgendaFarewell'), value:(d.stats?.top_user ? `${d.stats.top_user.full_name} (${d.stats.top_user.count})` : t('homeEmpty'))},
    {label:t('homeAgendaScene'), value:(d.scene?.top_media?.[0]?.name || d.scene?.theme?.title || t('homeNoTheme'))},
  ];
  const agenda = $('dashboardAgenda');
  if(agenda) agenda.innerHTML = `<div class="dashboardList">${agendaItems.map((item, idx)=>`<article class="dashboardListItem" style="--stagger:${idx*60}ms"><span>${escapeHtml(item.label)}</span><b>${escapeHtml(String(item.value || '—')).slice(0,120)}</b></article>`).join('')}</div>`;

  const quickLinks = [
    {key:'homeQuickProfile', icon:'👤', view:'profile', note:[me.school, me.grad_year].filter(Boolean).join(' • ') || me.class_label || 'MEra', action:()=>selectUser(me.id)},
    {key:'homeQuickDm', icon:'💬', view:'dm', note: dashboardAlerts ? `${dashboardAlerts} ${t('homeMiniAlerts')}` : t('homeStatusFallback'), action:()=>btnDM.click()},
    {key:'homeQuickLegacy', icon:'🗣️', view:'legacy', note: (d.legacy[0]?.message || d.scene?.theme?.subtitle || t('homeEmpty')).slice(0,56), action:()=>btnLegacy.click()},
    {key:'homeQuickOrbit', icon:'🪐', view:'meet', note: d.meetups[0]?.title || d.premium?.last_orbit?.title || t('noOrbitYet'), action:()=>btnMeet.click()},
    {key:'homeQuickScene', icon:'🎬', view:'scene', note: d.scene?.theme?.title || d.scene?.top_media?.[0]?.name || t('homeNoTheme'), action:()=>btnScene.click()},
    {key:'styleNav', icon:'👟', view:'style', note: t('styleSaveHint'), action:()=>btnStyle?.click()},
  ];
  const quick = $('dashboardQuickLinks');
  if(quick) {
    quick.innerHTML = quickLinks.map(link=>`<button class="dashboardQuickBtn" data-homeview="${link.view}"><span class="dashboardQuickIcon">${link.icon}</span><div class="dashboardQuickBody"><b>${t(link.key)}</b><small>${escapeHtml(String(link.note || t('homeOpen')))}</small></div><em>↗</em></button>`).join('');
    quick.querySelectorAll('[data-homeview]').forEach((btn, idx)=>btn.onclick = ()=>quickLinks[idx]?.action?.());
  }

  const feedItems = [];
  (d.scene?.recent_items || []).slice(0,3).forEach(item=>feedItems.push({icon:'🎬', title:item.full_name || 'MEra', body:`${sceneEntryTypeLabel(item.entry_type)} • ${item.media_title}`, meta:relTimeSafe(item.created_at)}));
  (d.legacy || []).slice(0,2).forEach(item=>feedItems.push({icon:'🗨️', title:item.full_name || 'MEra', body:(item.message || '').slice(0,120), meta:relTimeSafe(item.created_at)}));
  (d.meetups || []).slice(0,2).forEach(item=>feedItems.push({icon:'🪐', title:item.title || 'Orbit', body:[item.province,item.district].filter(Boolean).join(' • ') || 'MEra Orbit', meta:item.meeting_at || ''}));
  const feed = $('dashboardFeed');
  if(feed) feed.innerHTML = feedItems.length ? `<div class="dashboardFeed">${feedItems.map((item, idx)=>`<article class="dashboardFeedItem" style="--stagger:${idx*70}ms"><div class="dashboardFeedIcon">${item.icon}</div><div><b>${escapeHtml(item.title)}</b><p>${escapeHtml(item.body)}</p><small>${escapeHtml(item.meta)}</small></div></article>`).join('')}</div>` : dashboardEmptyActionGrid([
    {icon:'🎬', title:homeText('emptySceneTitle'), body:homeText('emptySceneBody'), action:t('sceneNav'), view:'scene'},
    {icon:'🪐', title:homeText('emptyOrbitTitle'), body:homeText('emptyOrbitBody'), action:t('meet'), view:'meet'},
    {icon:'💬', title:homeText('emptyLegacyTitle'), body:homeText('emptyLegacyBody'), action:t('legacy'), view:'legacy'},
    {icon:'👟', title:homeText('emptyStyleTitle'), body:homeText('emptyStyleBody'), action:t('styleNav'), view:'style'},
  ]);

  const styleItems = Array.isArray(d.style) ? d.style : [];
  const bestDeals = styleItems.filter(item=>String(item?.post_type || '') === 'deal' && styleDiscountPercent(item) > 0).sort((a,b)=>styleDealScore(b)-styleDealScore(a)).slice(0,5);
  const dealsEl = $('dashboardBestDeals');
  if(dealsEl){
    dealsEl.innerHTML = bestDeals.length ? `<div class="dashboardDealList">${bestDeals.map((item, idx)=>`<article class="dashboardDealItem" style="--stagger:${idx*55}ms"><div class="dashboardDealRank">0${idx+1}</div><div class="dashboardDealBody"><b>${escapeHtml(item.title || t('styleNoTitle'))}</b><p>${escapeHtml(styleStoreName(item))} • ${escapeHtml(formatPriceTRY(item.price_now))}${Number(item.price_before||0) > 0 ? ` <span class="muted"> / ${escapeHtml(formatPriceTRY(item.price_before))}</span>` : ''}</p><div class="dashboardDealMeta"><span class="styleDiscountPill">-%${styleDiscountPercent(item)}</span><span class="dashboardDealScore">${escapeHtml(t('homeDealScore'))}: ${styleDealScore(item)}</span></div></div></article>`).join('')}</div>` : dashboardMiniPlaybook('💸', homeText('dealEmptyTitle'), homeText('dealEmptyBody'), t('styleNav'), 'style');
  }

  const now = new Date();
  const dayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate());
  const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
  const yearStart = new Date(now.getFullYear(), 0, 1);
  const topOutfits = [
    {label:t('homeOutfitDay'), item:pickTopOutfitByWindow(styleItems, dayStart)},
    {label:t('homeOutfitMonth'), item:pickTopOutfitByWindow(styleItems, monthStart)},
    {label:t('homeOutfitYear'), item:pickTopOutfitByWindow(styleItems, yearStart)},
  ];
  const topOutfitsEl = $('dashboardTopOutfits');
  if(topOutfitsEl){
    topOutfitsEl.innerHTML = topOutfits.some(x=>x.item) ? `<div class="dashboardOutfitPicks">${topOutfits.map((entry, idx)=>`<article class="dashboardOutfitPick" style="--stagger:${idx*60}ms">${entry.item?.image_url ? `<img src="${escapeHtml(entry.item.image_url)}" alt="${escapeHtml(entry.item.title || 'outfit')}">` : `<div class="dashboardOutfitPlaceholder">👟</div>`}<div class="dashboardOutfitBody"><span>${escapeHtml(entry.label)}</span><b>${escapeHtml(entry.item?.title || t('homeOutfitEmpty'))}</b><p>${escapeHtml(entry.item ? `${styleStoreName(entry.item)} • ${Number(entry.item.like_count||0)+Number(entry.item.save_count||0)} skor` : t('homeOutfitEmpty'))}</p></div></article>`).join('')}</div>` : dashboardMiniPlaybook('🏆', homeText('outfitEmptyTitle'), homeText('outfitEmptyBody'), t('styleNav'), 'style');
  }

  const notifEl = $('dashboardNotificationsList');
  if(notifEl){
    const notifications = Array.isArray(d.notifications) ? d.notifications.slice(0,8) : [];
    notifEl.innerHTML = notifications.length ? `<div class="dashboardNoticeList">${notifications.map((n,idx)=>`<article class="dashboardNoticeItem ${Number(n.is_read)?'is-read':'is-new'}" style="--stagger:${idx*55}ms"><div><b>${escapeHtml(n.title || 'Bildirim')}</b><p>${escapeHtml(n.body || '')}</p><small>${escapeHtml(relTimeSafe(n.created_at))}</small></div>${Number(n.is_read)?'<span class="miniBadge">Live</span>':`<button class="btn tiny" data-home-read-notice="${n.id}">Okudum</button>`}</article>`).join('')}</div>` : dashboardEmptyActionGrid([
      {icon:'✨', title:homeText('noNoticeTitle'), body:homeText('noNoticeBody'), action:t('homeQuickProfile'), view:'profile'},
      {icon:'👥', title:homeText('noNoticePeopleTitle'), body:homeText('noNoticePeopleBody'), action:t('students'), view:'directory'},
    ]);
    notifEl.querySelectorAll('[data-home-read-notice]').forEach(btn=>btn.onclick=async()=>{ try{ await api('notifications_read','POST',{id:Number(btn.dataset.homeReadNotice)}); await loadDashboard(); }catch(e){ showAppNotice('Bildirim', e.message); } });
  }
  const btnReadAll = $('btnMarkNotificationsRead');
  if(btnReadAll) btnReadAll.onclick = async()=>{ try{ await api('notifications_read','POST',{}); await loadDashboard(); }catch(e){ showAppNotice('Bildirim', e.message); } };

  const suggest = $('dashboardSuggestions');
  const people = (d.users || []).filter(u=>Number(u.id)!==Number(me.id)).slice(0,3);
  const suggestions = [
    {title:t('homeSuggestPeople'), items:people.map(u=>u.full_name)},
    {title:t('homeSuggestEvents'), items:(d.meetups || []).slice(0,3).map(m=>m.title)},
    {title:t('homeSuggestScene'), items:(d.scene?.top_media || []).slice(0,3).map(x=>x.name)},
    {title:t('homeSuggestSchool'), items:[me.school || 'MEra', d.scene?.theme?.title || t('homeNoTheme')]},
  ];
  if(suggest) suggest.innerHTML = suggestions.map((group, idx)=>{
    const fallbackByIndex = [
      [me.school || 'MEra', t('students')],
      [t('meet'), t('homeQuickOrbit')],
      [t('sceneNav'), t('homeScenePrompt')],
      [me.class_label || t('homeNoTheme'), me.grad_year ? String(me.grad_year) : 'MEra']
    ];
    const chips = (group.items || []).filter(Boolean);
    const finalItems = chips.length ? chips : fallbackByIndex[idx] || [t('homeOpen')];
    return `<article class="dashboardSuggestGroup" style="--stagger:${idx*75}ms"><span>${escapeHtml(group.title)}</span>${finalItems.map(text=>`<button class="dashboardSuggestChip">${escapeHtml(text || '—')}</button>`).join('')}</article>`;
  }).join('');
  bindDashboardEmptyActions(dashboardCard || document);
}

async function loadScene(){
  if(!me || !sceneCard) return;
  const feed = $('sceneFeed'); const sidebar = $('sceneSidebar'); const theme = $('sceneThemeCard');
  if(feed) feed.innerHTML = dashboardSkeleton();
  if(sidebar) sidebar.innerHTML = dashboardSkeleton();
  if(theme) theme.innerHTML = dashboardSkeleton();
  const results = await Promise.allSettled([api('scene_summary'), api('scene_feed','GET',{limit:60})]);
  sceneSummaryCache = results[0].status === 'fulfilled' ? (results[0].value.summary || {}) : {};
  sceneFeedCache = results[1].status === 'fulfilled' ? (results[1].value.items || []) : [];
  renderScene();
}

function renderScene(){
  const summary = sceneSummaryCache || {};
  const items = sceneFeedCache || [];
  const theme = $('sceneThemeCard');
  if(theme){
    const themeMeta = [summary.top_media?.[0]?.name, summary.top_characters?.[0]?.name, summary.recent_items?.[0]?.media_title].filter(Boolean).slice(0,3);
    theme.innerHTML = `<div class="sceneThemeEyebrow">${t('sceneWeeklyTheme')}</div><h3>${escapeHtml(summary.theme?.title || t('homeNoTheme'))}</h3><p>${escapeHtml(summary.theme?.subtitle || '')}</p>${themeMeta.length ? `<div class="sceneThemeMeta">${themeMeta.map((chip, idx)=>`<span class="sceneThemeChip" style="--stagger:${idx*60}ms">${escapeHtml(String(chip))}</span>`).join('')}</div>` : `<div class="sceneThemeMeta"><span class="sceneThemeChip">${escapeHtml(t('homeScenePrompt'))}</span></div>`}`;
  }
  const sidebar = $('sceneSidebar');
  if(sidebar){
    const recentTitles = (summary.recent_items || []).slice(0,4).map(x=>x.media_title).filter(Boolean);
    sidebar.innerHTML = `
      <div class="sceneSidebarGroup">
        <span>${t('sceneTopMedia')}</span>
        ${(summary.top_media || []).slice(0,4).map(item=>`<div class="sceneSidebarRow"><b>${escapeHtml(item.name)}</b><small>${Number(item.count||0)}</small></div>`).join('') || `<div class="muted small">${t('sceneEmpty')}</div>`}
      </div>
      <div class="sceneSidebarGroup">
        <span>${t('sceneTopCharacters')}</span>
        ${(summary.top_characters || []).slice(0,4).map(item=>`<div class="sceneSidebarRow"><b>${escapeHtml(item.name)}</b><small>${Number(item.count||0)}</small></div>`).join('') || `<div class="muted small">${t('sceneEmpty')}</div>`}
      </div>
      <div class="sceneSidebarGroup sceneSidebarGroup--reaction">
        <span>${t('sceneTopReaction')}</span>
        <div class="sceneSidebarReaction">${summary.top_reaction ? `${escapeHtml(summary.top_reaction.reaction)} <b>${Number(summary.top_reaction.count||0)}</b>` : `<span class="muted small">${t('sceneEmpty')}</span>`}</div>
      </div>
      <div class="sceneSidebarGroup">
        <span>${t('sceneRecentWatching')}</span>
        <div class="sceneChipWrap">${recentTitles.length ? recentTitles.map(text=>`<button class="dashboardSuggestChip">${escapeHtml(text)}</button>`).join('') : `<div class="muted small">${t('sceneEmpty')}</div>`}</div>
      </div>`;
  }
  const feed = $('sceneFeed');
  if(feed){
    if(!items.length){ feed.innerHTML = `<p class="muted">${t('sceneEmpty')}</p>`; return; }
    const reactions = [
      {key:'🔥', label:t('sceneReactFire')},
      {key:'✨', label:t('sceneReactGlow')},
      {key:'🫶', label:t('sceneReactMood')},
    ];
    feed.innerHTML = `<div class="sceneFeedList">${items.map((item, idx)=>`
      <article class="scenePostCard" data-scene-post="${item.id}" style="--stagger:${idx*55}ms">
        <div class="scenePostHead">
          <div class="scenePostAvatar">${avatarHtml({full_name:item.full_name, photo_url:item.photo_url})}</div>
          <div>
            <b>${escapeHtml(item.full_name || 'MEra')}</b>
            <small>${escapeHtml(item.school || '')} • ${escapeHtml(relTimeSafe(item.created_at))}</small>
          </div>
          <span class="sceneTypeTag">${escapeHtml(sceneEntryTypeLabel(item.entry_type))}</span>
        </div>
        <div class="scenePostBody">
          <h4>${escapeHtml(item.title || '')}</h4>
          <div class="sceneMetaRow">
            <span class="tag">🎞️ ${escapeHtml(item.media_title || '—')}</span>
            ${item.character_name ? `<span class="tag">🧍 ${escapeHtml(item.character_name)}</span>` : ''}
            ${item.soundtrack_platform ? `<span class="tag">🎵 ${escapeHtml(item.soundtrack_platform)}</span>` : ''}
          </div>
          <p>${escapeHtml(item.body || '')}</p>
          ${item.soundtrack_url ? `<a class="sceneLink" href="${escapeHtml(item.soundtrack_url)}" target="_blank" rel="noreferrer">${escapeHtml(item.soundtrack_url)}</a>` : ''}
        </div>
        <div class="sceneReactions">
          ${reactions.map(r=>{
            const hit = (item.reactions || []).find(x=>x.reaction===r.key);
            const count = Number(hit?.count || 0);
            return `<button class="sceneReactBtn ${item.my_reaction===r.key ? 'active' : ''}" data-scenereact="${item.id}" data-reaction="${r.key}">${r.key} <span>${count}</span></button>`;
          }).join('')}
        </div>
      </article>`).join('')}</div>`;
    feed.querySelectorAll('[data-scenereact]').forEach(btn=>btn.onclick = async ()=>{
      try{
        await api('scene_react_toggle','POST',{post_id:Number(btn.dataset.scenereact), reaction:String(btn.dataset.reaction||'🔥')});
        await loadScene();
      }catch(e){ setMsg($('sceneMsg'), e.message); }
    });
  }
}

$('btnScenePost')?.addEventListener('click', async ()=>{
  try{
    setMsg($('sceneMsg'), '');
    await api('scene_post_create','POST',{
      entry_type: $('sceneEntryType')?.value || 'scene',
      media_kind: $('sceneMediaKind')?.value || 'film',
      media_title: $('sceneMediaTitle')?.value?.trim() || '',
      character_name: $('sceneCharacterName')?.value?.trim() || '',
      title: $('scenePostTitle')?.value?.trim() || '',
      body: $('sceneBody')?.value?.trim() || '',
      soundtrack_platform: $('scenePlatform')?.value || '',
      soundtrack_url: $('sceneSoundtrackUrl')?.value?.trim() || '',
      theme_label: sceneSummaryCache?.theme?.title || '',
    });
    ['sceneMediaTitle','sceneCharacterName','scenePostTitle','sceneBody','sceneSoundtrackUrl'].forEach(id=>{ const el=$(id); if(el) el.value=''; });
    if($('scenePlatform')) $('scenePlatform').value='';
    setMsg($('sceneMsg'), t('scenePublished'));
    await loadScene();
  }catch(e){ setMsg($('sceneMsg'), e.message); }
});



function normalizeStyleItems(items){
  return (Array.isArray(items) ? items : []).map((item, idx)=>({
    name: String(item?.name || item?.item_name || '').trim(),
    store: String(item?.store || item?.store_name || '').trim(),
    price: String(item?.price || item?.price_now || '').trim(),
    link: String(item?.link || item?.product_url || '').trim(),
    order: idx + 1,
  })).filter(item=>item.name || item.store || item.price || item.link);
}
function styleItemsLabel(){
  return styleComposeMode === 'deal' ? t('styleItemsLabelDeal') : t('styleItemsLabel');
}
function renderStyleDraftItems(){
  const wrap = $('styleItemsList');
  const label = $('styleItemsLabel');
  if(label) label.textContent = styleItemsLabel();
  if(!wrap) return;
  if(!styleDraftItems.length){
    wrap.innerHTML = `<div class="muted small">${escapeHtml(t('styleSaveHint'))}</div>`;
    return;
  }
  wrap.innerHTML = styleDraftItems.map((item, idx)=>`<div class="styleItemRow">
    <input class="input" data-styleitem="name" data-idx="${idx}" placeholder="${escapeHtml(t('styleItemName'))}" value="${escapeHtml(item.name || '')}">
    <input class="input" data-styleitem="store" data-idx="${idx}" placeholder="${escapeHtml(t('styleItemStore'))}" value="${escapeHtml(item.store || '')}">
    <input class="input" data-styleitem="price" data-idx="${idx}" placeholder="${escapeHtml(t('styleItemPrice'))}" value="${escapeHtml(item.price || '')}">
    <input class="input" data-styleitem="link" data-idx="${idx}" placeholder="${escapeHtml(t('styleItemLink'))}" value="${escapeHtml(item.link || '')}">
    <button type="button" class="btn" data-styleitem-remove="${idx}">${escapeHtml(t('styleRemove'))}</button>
  </div>`).join('');
}
function addStyleDraftItem(prefill={}){
  styleDraftItems.push({name:'', store:'', price:'', link:'', ...prefill});
  renderStyleDraftItems();
}
function setStyleStoreFilter(store){
  styleStoreFilter = store || 'all';
  document.body.dataset.styleFeedMode = styleFeedMode;
  renderStyle();
}
async function toggleStyleAction(kind, postId){
  const action = kind === 'save' ? 'style_toggle_save' : 'style_toggle_like';
  const item = styleFeedCache.find(x=>Number(x.id)===Number(postId));
  try{
    const r = await api(action, 'POST', {post_id: postId});
    if(item){
      if(kind === 'save'){
        item.viewer_saved = !!r.saved;
        item.save_count = Number(r.count || 0);
        setMsg($('styleMsg'), item.viewer_saved ? t('styleFavoriteAdded') : t('styleFavoriteRemoved'));
      }else{
        item.viewer_liked = !!r.liked;
        item.like_count = Number(r.count || 0);
      }
    }
  }catch(err){
    if(kind !== 'save') throw err;
    if(item){
      item.viewer_saved = !item.viewer_saved;
      item.save_count = Math.max(0, Number(item.save_count||0) + (item.viewer_saved ? 1 : -1));
      setMsg($('styleMsg'), item.viewer_saved ? t('styleFavoriteAdded') : t('styleFavoriteRemoved'));
    }
  }
  renderStyle();
}
async function loadStyle(){
  if(!me || !styleCard) return;
  const feed = $('styleFeed'); const summary = $('styleSummary'); const carousel = $('styleCarousel');
  if(feed) feed.innerHTML = dashboardSkeleton();
  if(summary) summary.innerHTML = dashboardSkeleton();
  if(carousel) carousel.innerHTML = dashboardSkeleton();
  if(!styleDraftItems.length) styleDraftItems = [{name:'',store:'',price:'',link:''}];
  setStyleComposeMode(styleComposeMode);
  setStyleFeedMode(styleFeedMode);
  renderStyleDraftItems();
  const results = await Promise.allSettled([api('style_summary'), api('style_feed','GET',{limit:80})]);
  styleSummaryCache = results[0].status === 'fulfilled' ? (results[0].value.summary || {}) : {};
  styleFeedCache = results[1].status === 'fulfilled' ? (results[1].value.items || []) : [];
  renderStyle();
}

function setStyleFieldMeta(id, labelKey, placeholderKey){
  const el = $(id);
  if(!el) return;
  const field = el.closest('.profileField');
  const label = field ? field.querySelector('label') : null;
  if(label && labelKey) label.textContent = t(labelKey);
  if(placeholderKey && ('placeholder' in el)) el.placeholder = t(placeholderKey);
}
function setStyleComposeMode(mode){
  styleComposeMode = mode === 'deal' ? 'deal' : 'outfit';
  const isDeal = styleComposeMode === 'deal';
  const typeSelect = $('stylePostType');
  if(typeSelect) typeSelect.value = styleComposeMode;
  document.querySelectorAll('[data-stylecompose]').forEach(btn=>btn.classList.toggle('active', btn.dataset.stylecompose===styleComposeMode));
  const titleEl = document.querySelector('.styleComposerPanel h3');
  const descEl = document.querySelector('#styleCard .styleHead p.muted');
  const guideTitle = document.querySelector('.styleGuideCard b');
  const guideBody = document.querySelector('.styleGuideCard p');
  if(titleEl) titleEl.textContent = isDeal ? t('styleModeDealTitle') : t('styleModeOutfitTitle');
  if(descEl) descEl.textContent = isDeal ? t('styleModeDealBody') : t('styleModeOutfitBody');
  if(guideTitle) guideTitle.textContent = isDeal ? t('styleDealFocusTitle') : t('styleOutfitFocusTitle');
  if(guideBody) guideBody.textContent = isDeal ? t('styleDealFocusBody') : t('styleOutfitFocusBody');
  setStyleFieldMeta('styleTitleInput', isDeal ? 'styleDealTitleLabel' : 'styleTitleLabel', isDeal ? 'styleDealTitlePh' : 'styleTitlePh');
  setStyleFieldMeta('styleBrandInput', isDeal ? 'styleDealStoreLabel' : 'styleBrandLabel', isDeal ? 'styleDealStorePh' : 'styleBrandPh');
  setStyleFieldMeta('stylePriceNow', isDeal ? 'styleDealPriceNow' : 'stylePriceNow', isDeal ? 'styleDealPriceNowPh' : 'stylePriceNowPh');
  setStyleFieldMeta('stylePriceBefore', isDeal ? 'styleDealPriceBefore' : 'stylePriceBefore', isDeal ? 'styleDealPriceBeforePh' : 'stylePriceBeforePh');
  setStyleFieldMeta('styleLinkInput', isDeal ? 'styleDealLinkLabel' : 'styleLinkLabel', isDeal ? 'styleDealLinkPh' : 'styleLinkPh');
  setStyleFieldMeta('styleTagsInput', isDeal ? 'styleDealTagsLabel' : 'styleTagsLabel', isDeal ? 'styleDealTagsPh' : 'styleTagsPh');
  setStyleFieldMeta('styleBodyInput', isDeal ? 'styleDealBodyLabel' : 'styleBodyLabel', isDeal ? 'styleDealBodyPh' : 'styleBodyPh');
  setStyleFieldMeta('styleImageInput', isDeal ? 'styleDealImageLabel' : 'styleImageLabel');
  const itemsField = $('styleItemsList')?.closest('.profileField');
  if(itemsField) itemsField.classList.toggle('hidden', isDeal);
  const addItemBtn = $('btnAddStyleItem');
  if(addItemBtn) addItemBtn.classList.toggle('hidden', isDeal);
  document.body.dataset.styleMode = styleComposeMode;
  renderStyleDraftItems();
  renderStyleDiscountPreview();
}
function setStyleFeedMode(mode){
  styleFeedMode = ['all','outfit','deal','saved'].includes(mode) ? mode : 'all';
  document.querySelectorAll('[data-stylefilter]').forEach(btn=>btn.classList.toggle('active', btn.dataset.stylefilter===styleFeedMode));
  document.body.dataset.styleFeedMode = styleFeedMode;
  renderStyle();
}
function formatPriceTRY(v){
  const n = Number(v || 0);
  if(!Number.isFinite(n) || n <= 0) return '';
  try{ return new Intl.NumberFormat(lang === 'en' ? 'en-US' : 'tr-TR', {maximumFractionDigits:0}).format(n) + ' ₺'; }catch(_){ return String(Math.round(n)) + ' ₺'; }
}
function styleTypeLabel(type){ return type === 'deal' ? t('styleDiscountBadge') : t('styleOutfitBadge'); }
function styleStoreName(item){
  return String(item?.brand_name || item?.store_name || item?.store || '').trim() || t('styleNoStore');
}
function styleVisibleItems(){
  const allItems = Array.isArray(styleFeedCache) ? styleFeedCache : [];
  return allItems.filter(item => {
    const modeOk = styleFeedMode === 'all' || (styleFeedMode === 'saved' ? !!item.viewer_saved : String(item.post_type||'outfit')===styleFeedMode);
    return modeOk && (styleStoreFilter === 'all' || styleNameCompare(styleStoreName(item), styleStoreFilter));
  });
}
function renderStyle(){
  const summary = styleSummaryCache || {};
  const allItems = Array.isArray(styleFeedCache) ? styleFeedCache : [];
  const items = styleVisibleItems();
  const tags = (summary.trending_tags || []).slice(0,6);
  const stores = [t('styleAllStores'), ...Array.from(new Set(allItems.map(styleStoreName).filter(Boolean)))];
  const summaryEl = $('styleSummary');
  if(summaryEl){
    summaryEl.innerHTML = `
      <div class="styleSummaryCard">
        <div>
          <div class="sceneThemeEyebrow">${escapeHtml(t('styleSummaryTitle'))}</div>
          <h3>${escapeHtml(summary.hero_title || t('styleTitle'))}</h3>
          <p>${escapeHtml(summary.hero_body || t('styleSummaryBody'))}</p>
        </div>
        <div class="styleSummaryStats">
          <div class="styleStat"><span>${escapeHtml(t('styleTabOutfits'))}</span><b>${Number(summary.outfit_count||0)}</b></div>
          <div class="styleStat"><span>${escapeHtml(t('styleTabDeals'))}</span><b>${Number(summary.deal_count||0)}</b></div>
          <div class="styleStat"><span>${escapeHtml(t('styleTrendLabel'))}</span><b>${Number(tags.length||0)}</b></div>
        </div>
        <div class="styleSpotlightGrid"><div class="styleSpotlightCard styleSpotlightCard--outfit"><span>${escapeHtml(t('styleSpotlightOutfit'))}</span><b>${escapeHtml(t('styleTabOutfits'))}</b><p>${escapeHtml(t('styleSpotlightOutfitBody'))}</p></div><div class="styleSpotlightCard styleSpotlightCard--deal"><span>${escapeHtml(t('styleSpotlightDeal'))}</span><b>${escapeHtml(t('styleTabDeals'))}</b><p>${escapeHtml(t('styleSpotlightDealBody'))}</p></div></div>
        <div class="sceneChipWrap">
          ${tags.length ? tags.map(tag=>`<button class="dashboardSuggestChip">#${escapeHtml(String(tag).replace(/^#/,''))}</button>`).join('') : `<span class="muted small">${escapeHtml(t('styleEmpty'))}</span>`}
        </div>
      </div>
      <div class="styleMiniColumns">
        <div class="sceneSidebarGroup">
          <span>${escapeHtml(t('styleSummaryOutfits'))}</span>
          ${(summary.latest_outfits || []).slice(0,3).map(item=>`<div class="sceneSidebarRow"><b>${escapeHtml(item.title || t('styleNoTitle'))}</b><small>${escapeHtml(styleStoreName(item))}</small></div>`).join('') || `<div class="muted small">${escapeHtml(t('styleEmpty'))}</div>`}
        </div>
        <div class="sceneSidebarGroup">
          <span>${escapeHtml(t('styleSummaryDeals'))}</span>
          ${(summary.latest_deals || []).slice(0,3).map(item=>`<div class="sceneSidebarRow"><b>${escapeHtml(item.title || t('styleNoTitle'))}</b><small>${escapeHtml(formatPriceTRY(item.price_now))}</small></div>`).join('') || `<div class="muted small">${escapeHtml(t('styleEmpty'))}</div>`}
        </div>
      </div>`;
  }
  const storeWrap = $('styleStoreFilters');
  if(storeWrap){
    storeWrap.innerHTML = stores.map(store=>{
      const val = store === t('styleAllStores') ? 'all' : store;
      return `<button class="styleStoreChip ${styleStoreFilter===val?'active':''}" data-style-store="${escapeHtml(val)}">${escapeHtml(store)}</button>`;
    }).join('');
  }
  const featured = [...allItems].sort((a,b)=>(Number(b.like_count||0)+Number(b.save_count||0))-(Number(a.like_count||0)+Number(a.save_count||0))).slice(0,8);
  const carousel = $('styleCarousel');
  if(carousel){
    carousel.innerHTML = featured.length ? featured.map(item=>{
      const discount = styleDiscountPercent(item);
      return `<article class="styleCarouselCard ${item.post_type==='deal' ? 'styleCarouselCard--deal' : 'styleCarouselCard--outfit'}">
        <div class="styleCarouselTop"><span class="sceneTypeTag">${escapeHtml(styleTypeLabel(item.post_type))}</span>${discount ? `<span class="styleDiscountPill">-%${discount}</span>` : ''}</div>
        ${item.image_url ? `<img src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.title || 'style')}">` : `<img alt="placeholder">`}
        <div><b>${escapeHtml(item.title || t('styleNoTitle'))}</b><div class="muted small">${escapeHtml(styleStoreName(item))}</div></div>
        <div class="styleActions"><button class="styleActionBtn ${item.viewer_liked?'active':''}" data-style-like="${item.id}">❤ ${Number(item.like_count||0)}</button><button class="styleActionBtn ${item.viewer_saved?'active':''}" data-style-save="${item.id}">🔖 ${Number(item.save_count||0)}</button></div>
      </article>`;
    }).join('') : `<div class="muted small">${escapeHtml(t('styleEmpty'))}</div>`;
  }
  const feed = $('styleFeed');
  if(feed){
    if(!items.length){ feed.innerHTML = `<p class="muted">${escapeHtml(t('styleEmpty'))}</p>`; return; }
    feed.innerHTML = `<div class="styleFeedList">${items.map((item, idx)=>{
      const discount = styleDiscountPercent(item);
      const tagHtml = (Array.isArray(item.tags) ? item.tags : []).slice(0,5).map(tag=>`<span class="sceneThemeChip">#${escapeHtml(String(tag).replace(/^#/,''))}</span>`).join('');
      const products = Array.isArray(item.items) ? item.items : [];
      const score = item.post_type==='deal' ? styleDealScore(item) : (Number(item.like_count||0)+Number(item.save_count||0));
      return `<article class="stylePostCard stylePostCard--${item.post_type==='deal' ? 'deal' : 'outfit'}" style="--stagger:${idx*45}ms">
        ${item.image_url ? `<div class="stylePostImageWrap"><img class="stylePostImage" src="${escapeHtml(item.image_url)}" alt="${escapeHtml(item.title || 'style')}"/>${discount ? `<span class="styleImageBadge">-%${discount}</span>` : ''}</div>` : `<div class="stylePostImageWrap stylePostImageWrap--placeholder"><div class="stylePlaceholderIcon">${item.post_type==='deal' ? '🏷️' : '👟'}</div>${discount ? `<span class="styleImageBadge">-%${discount}</span>` : ''}</div>`}
        <div class="stylePostContent">
          <div class="scenePostHead">
            <div class="scenePostAvatar">${avatarHtml({full_name:item.full_name, photo_url:item.user_photo_url || item.photo_url})}</div>
            <div>
              <b>${escapeHtml(item.full_name || 'MEra')}</b>
              <small>${escapeHtml(styleStoreName(item))} • ${escapeHtml(relTimeSafe(item.created_at))}</small>
            </div>
            <span class="sceneTypeTag">${escapeHtml(styleTypeLabel(item.post_type))}</span>
          </div>
          <h4>${escapeHtml(item.title || '')}</h4>
          <div class="styleMetaLine">${item.post_type==='deal' ? `<span class="styleDealScoreTag">${escapeHtml(t('homeDealScore'))}: ${score}</span>` : ''}
            ${item.category ? `<span class="tag">${escapeHtml(item.category)}</span>` : ''}
            ${item.brand_name ? `<span class="tag">${escapeHtml(item.brand_name)}</span>` : ''}
            ${Number(item.price_now||0) > 0 ? `<span class="tag">💸 ${escapeHtml(formatPriceTRY(item.price_now))}</span>` : ''}
            ${Number(item.price_before||0) > 0 ? `<span class="tag muted">${escapeHtml(formatPriceTRY(item.price_before))}</span>` : ''}
            ${discount ? `<span class="styleDiscountPill">-%${discount}</span>` : ''}
          </div>
          ${item.post_type==='deal' ? `<div class="styleDealDetailBox"><div><span>${escapeHtml(t('styleDealDiscountLabel'))}</span><b>${discount ? `-%${discount}` : escapeHtml(t('styleDealNoDiscount'))}</b></div><div><span>${escapeHtml(t('styleDealSavingLabel'))}</span><b>${styleDiscountAmount(item) ? escapeHtml(formatPriceTRY(styleDiscountAmount(item))) : '—'}</b></div><div><span>${escapeHtml(t('styleDealLinkLabel'))}</span>${item.product_url ? `<a class="sceneLink" href="${escapeHtml(item.product_url)}" target="_blank" rel="noreferrer">${escapeHtml(t('styleSeeProduct'))}</a>` : `<b>—</b>`}</div></div>` : ''}
          <p>${escapeHtml(item.body || '')}</p>
          ${products.length && item.post_type!=='deal' ? `<div class="styleProductsBox"><h5>${escapeHtml(t('styleProductsBox'))}</h5>${products.map(prod=>`<div class="styleProductItem"><div class="styleProductItemMeta"><b>${escapeHtml(prod.item_name || prod.name || '')}</b><small>${escapeHtml(prod.store_name || '')}</small></div><div style="display:flex;align-items:center;gap:10px">${prod.price_now ? `<span class="styleProductItemPrice">${escapeHtml(formatPriceTRY(prod.price_now))}</span>` : ''}${prod.product_url ? `<a class="sceneLink" href="${escapeHtml(prod.product_url)}" target="_blank" rel="noreferrer">${escapeHtml(t('styleSeeProduct'))}</a>` : ''}</div></div>`).join('')}</div>` : ''}
          ${tagHtml ? `<div class="sceneThemeMeta">${tagHtml}</div>` : ''}
          ${item.product_url && item.post_type!=='deal' ? `<a class="sceneLink" href="${escapeHtml(item.product_url)}" target="_blank" rel="noreferrer">${escapeHtml(t('styleSeeProduct'))}</a>` : ''}
          <div class="styleActionRow"><div class="styleActions"><button class="styleActionBtn ${item.viewer_liked?'active':''}" data-style-like="${item.id}">❤ ${escapeHtml(t('styleLike'))} • ${Number(item.like_count||0)}</button><button class="styleActionBtn ${item.viewer_saved?'active':''}" data-style-save="${item.id}">${item.viewer_saved?'✅':'🔖'} ${escapeHtml(item.viewer_saved ? t('styleSaved') : t('styleSave'))} • ${Number(item.save_count||0)}</button></div><span class="muted small">${escapeHtml(t('styleFeatured'))} • ${Number(item.like_count||0)+Number(item.save_count||0)}</span></div>
        </div>
      </article>`;
    }).join('')}</div>`;
  }
}

document.querySelectorAll('[data-stylecompose]').forEach(btn=>btn.addEventListener('click', ()=>setStyleComposeMode(btn.dataset.stylecompose || 'outfit')));
document.querySelectorAll('[data-stylefilter]').forEach(btn=>btn.addEventListener('click', ()=>setStyleFeedMode(btn.dataset.stylefilter || 'all')));
['stylePriceNow','stylePriceBefore'].forEach(id=>$(id)?.addEventListener('input', renderStyleDiscountPreview));
$('stylePostType')?.addEventListener('change', (e)=>setStyleComposeMode(e.target.value || 'outfit'));
$('btnAddStyleItem')?.addEventListener('click', ()=>addStyleDraftItem());
$('styleItemsList')?.addEventListener('input', (e)=>{
  const el = e.target.closest('[data-styleitem]');
  if(!el) return;
  const idx = Number(el.dataset.idx || -1);
  const key = el.dataset.styleitem;
  if(idx < 0 || !styleDraftItems[idx]) return;
  styleDraftItems[idx][key] = el.value;
});
$('styleItemsList')?.addEventListener('click', (e)=>{
  const btn = e.target.closest('[data-styleitem-remove]');
  if(!btn) return;
  const idx = Number(btn.dataset.styleitemRemove || -1);
  if(idx < 0) return;
  styleDraftItems.splice(idx, 1);
  renderStyleDraftItems();
});
$('styleFeed')?.addEventListener('click', async (e)=>{
  const likeBtn = e.target.closest('[data-style-like]');
  const saveBtn = e.target.closest('[data-style-save]');
  if(likeBtn) return toggleStyleAction('like', Number(likeBtn.dataset.styleLike || 0)).catch(err=>setMsg($('styleMsg'), err.message || '')); 
  if(saveBtn) return toggleStyleAction('save', Number(saveBtn.dataset.styleSave || 0)).catch(err=>setMsg($('styleMsg'), err.message || ''));
});
$('styleCarousel')?.addEventListener('click', async (e)=>{
  const likeBtn = e.target.closest('[data-style-like]');
  const saveBtn = e.target.closest('[data-style-save]');
  if(likeBtn) return toggleStyleAction('like', Number(likeBtn.dataset.styleLike || 0)).catch(err=>setMsg($('styleMsg'), err.message || ''));
  if(saveBtn) return toggleStyleAction('save', Number(saveBtn.dataset.styleSave || 0)).catch(err=>setMsg($('styleMsg'), err.message || ''));
});
$('styleStoreFilters')?.addEventListener('click', (e)=>{
  const chip = e.target.closest('[data-style-store]');
  if(!chip) return;
  setStyleStoreFilter(chip.dataset.styleStore || 'all');
});
$('btnStylePost')?.addEventListener('click', async ()=>{
  try{
    setMsg($('styleMsg'), '');
    const fd = new FormData();
    fd.append('post_type', $('stylePostType')?.value || styleComposeMode || 'outfit');
    fd.append('category', $('styleCategory')?.value || 'sneaker');
    fd.append('title', $('styleTitleInput')?.value?.trim() || '');
    fd.append('brand_name', $('styleBrandInput')?.value?.trim() || '');
    fd.append('price_now', $('stylePriceNow')?.value?.trim() || '');
    fd.append('price_before', $('stylePriceBefore')?.value?.trim() || '');
    fd.append('product_url', $('styleLinkInput')?.value?.trim() || '');
    fd.append('tags', $('styleTagsInput')?.value?.trim() || '');
    fd.append('body', $('styleBodyInput')?.value?.trim() || '');
    if((fd.get('post_type') || styleComposeMode) === 'deal') {
      const now = readStylePriceInput('stylePriceNow');
      const before = readStylePriceInput('stylePriceBefore');
      if(!fd.get('product_url')) throw new Error(t('styleDealLinkRequired'));
      if(!(before > now && now > 0)) throw new Error(t('styleDealPriceRequired'));
      fd.append('items_json', '[]');
    }else{
      fd.append('items_json', JSON.stringify(normalizeStyleItems(styleDraftItems)));
    }
    const file = $('styleImageInput')?.files?.[0];
    if(file) fd.append('photo', file);
    await api('style_post_create','POST',fd,true);
    ['styleTitleInput','styleBrandInput','stylePriceNow','stylePriceBefore','styleLinkInput','styleTagsInput','styleBodyInput','styleImageInput'].forEach(id=>{ const el=$(id); if(el){ el.value=''; } });
    styleDraftItems = [{name:'',store:'',price:'',link:''}];
    renderStyleDraftItems();
    setMsg($('styleMsg'), t('stylePublished'));
    await loadStyle();
  }catch(e){ setMsg($('styleMsg'), e.message); }
});

function attachProfileParallax(){
  const cover = document.querySelector('.profileCover');
  if(!cover || cover.dataset.parallaxBound==='1') return;
  cover.dataset.parallaxBound='1';
  const onMove = (e)=>{
    const r = cover.getBoundingClientRect();
    const px = ((e.clientX - r.left) / Math.max(r.width,1)) - .5;
    const py = ((e.clientY - r.top) / Math.max(r.height,1)) - .5;
    cover.style.transform = `translate3d(${px * 10}px, ${py * 8}px, 0) scale(1.02)`;
  };
  cover.addEventListener('mousemove', onMove);
  cover.addEventListener('mouseleave', ()=>{ cover.style.transform=''; });
}

if(btnAdminPortal){
  btnAdminPortal.onclick = ()=>{ window.location.href = "admin.html"; };
}

function formatAdminRemaining(raw){
  if(!raw) return "";
  const iso = String(raw).includes("T") ? String(raw) : String(raw).replace(" ", "T") + "Z";
  const diff = new Date(iso).getTime() - Date.now();
  if(!Number.isFinite(diff) || diff <= 0) return "admin süresi doldu";
  const total = Math.floor(diff/1000);
  const d = Math.floor(total/86400);
  const h = Math.floor((total%86400)/3600);
  const m = Math.floor((total%3600)/60);
  const s = total%60;
  if(d>0) return `Geçici admin: ${d}g ${h}s ${m}dk`;
  if(h>0) return `Geçici admin: ${h}s ${m}dk`;
  if(m>0) return `Geçici admin: ${m}dk ${s}sn`;
  return `Geçici admin: ${s}sn`;
}

function updateAdminCountdownPill(){
  if(!adminCountdownPill) return;
  const until = me?.admin_until;
  const show = !!(me && Number(me.is_admin)===1 && until);
  adminCountdownPill.classList.toggle("hidden", !show);
  if(show) adminCountdownPill.textContent = formatAdminRemaining(until);
}

setInterval(updateAdminCountdownPill, 1000);

const __oldSelectUser = selectUser;
selectUser = async function(...args){ const res = await __oldSelectUser.apply(this, args); setTimeout(()=>attachProfileParallax(), 30); return res; };

// Login / Register
btnLogin.onclick = async ()=>{
  try{
    setMsg(authMsg,"");
    const email = $("loginEmail").value.trim().toLowerCase();
    const password = $("loginPass").value;
    if(!isValidEmail(email)) throw new Error(lang==='en' ? 'Enter a valid email address.' : 'Geçerli bir e-posta gir.');
    if(!password) throw new Error(lang==='en' ? 'Enter your password.' : 'Şifreni gir.');
    const d = await api("login","POST",{email,password});
    if(d.token) setToken(d.token);
    setMe(d.user);
    activateUserSession(d.user);
    if(Number(d.user?.is_admin) === 1 && new URLSearchParams(location.search).get('fromAdmin') !== '1'){ window.location.href = 'admin.html'; return; }
    await refreshStats();
    await loadUsers();
    homeEntrancePending = true;
    switchView("dashboard");
    await loadDashboard();
    maybeShowFirstWelcome(d.user);
    await loadAppNotifications();
    await checkReportReminders();
  }catch(e){ setMsg(authMsg, e.message); }
};

function isValidEmail(email){
  return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i.test(String(email||"").trim());
}

const GENERIC_SCHOOL_NAMES = new Set([
  "lise","lisem","kolej","koleji","ortaokul","ortaokulu","universite","üniversite","universitesi",
  "ilkokul","ilkokulu","anaokulu","okul","okulu","school","college","university","high school",
  "orta okul","imam hatip","anadolu","fen lisesi","meslek lisesi"
]);
function normalizeSchoolForValidation(name){
  return String(name||"").trim().toLocaleLowerCase("tr-TR").replace(/\u0307/g,"").replace(/[^a-z0-9çğıöşü\s]/giu," ").replace(/\s+/g," ");
}
function isValidSchoolName(name){
  const value = String(name||"").trim();
  const normalized = normalizeSchoolForValidation(value);
  if(value.length < 2 || !/[\p{L}\p{N}]/u.test(value)) return false;
  if(GENERIC_SCHOOL_NAMES.has(normalized)) return false;
  const tokens = normalized.split(" ").filter(Boolean);
  const genericTokens = new Set(["lise","lisesi","kolej","koleji","ortaokul","ortaokulu","universite","üniversite","universitesi","ilkokul","ilkokulu","anaokulu","okul","okulu","anadolu","fen","meslek"]);
  return tokens.some(tok => !genericTokens.has(tok) && tok.length >= 2);
}

function updateAuthFieldState(input, ok){
  const field = input?.closest('.authField');
  if(!field) return;
  field.classList.remove('is-valid','is-invalid');
  if(ok === true) field.classList.add('is-valid');
  if(ok === false) field.classList.add('is-invalid');
}

function getPasswordStrengthMeta(password, {email='', fullName='', confirm=''} = {}){
  const value = String(password || '');
  const lowered = value.toLowerCase();
  const compactName = String(fullName || '').toLowerCase().replace(/\s+/g,'');
  const emailBase = String(email || '').toLowerCase().split('@')[0];
  const commonPatterns = ['123456','12345678','123456789','1234567890','password','qwerty','asdfgh','111111','000000','abc123','password1','mera123','iloveyou','admin'];
  const rules = {
    length: value.length >= 10,
    case: /[a-zçğıöşü]/.test(value) && /[A-ZÇĞİÖŞÜ]/.test(value),
    number: /\d/.test(value),
    special: /[^A-Za-z0-9çğıöşüÇĞİÖŞÜ\s]/.test(value),
    match: confirm === '' ? false : value !== '' && value === String(confirm),
    common: value.length >= 10 && !commonPatterns.some(p => lowered.includes(p)) && (!emailBase || !lowered.includes(emailBase)) && (!compactName || compactName.length < 3 || !lowered.includes(compactName))
  };
  const score = Object.values(rules).filter(Boolean).length;
  let level = 'weak';
  let label = lang === 'en' ? 'Weak' : 'Zayıf';
  if(score >= 6){ level = 'strong'; label = lang === 'en' ? 'Strong' : 'Güçlü'; }
  else if(score >= 4){ level = 'medium'; label = lang === 'en' ? 'Medium' : 'Orta'; }
  else if(score === 0 && value === ''){ label = t('passwordStrengthWaiting'); }
  return {rules, score, level, label};
}

function renderPasswordStrength(){
  const password = $('regPass')?.value || '';
  const confirm = regPassConfirm?.value || '';
  const email = $('regEmail')?.value || '';
  const fullName = $('regName')?.value || '';
  const meta = getPasswordStrengthMeta(password, {email, fullName, confirm});
  if(regStrengthLabel) regStrengthLabel.textContent = meta.label;
  if(regStrengthBar){
    const width = password ? Math.max(16, (meta.score / 6) * 100) : 12;
    regStrengthBar.style.width = `${width}%`;
    regStrengthBar.style.filter = meta.level === 'strong' ? 'hue-rotate(80deg) saturate(1.08)' : meta.level === 'medium' ? 'hue-rotate(20deg)' : 'none';
  }
  document.querySelectorAll('#regPasswordRules [data-rule]').forEach(el=>{
    const key = el.dataset.rule;
    const state = meta.rules[key];
    el.classList.remove('ok','bad');
    if(password || key === 'match'){ el.classList.add(state ? 'ok' : 'bad'); }
  });
  updateAuthFieldState($('regPass'), password ? meta.score >= 4 && meta.rules.common && meta.rules.length : null);
  if(regPassConfirm) updateAuthFieldState(regPassConfirm, confirm ? meta.rules.match : null);
  return meta;
}

function validatePasswordBeforeSubmit(password, context = {}){
  const meta = getPasswordStrengthMeta(password, context);
  if(!meta.rules.length) throw new Error(lang==='en' ? 'Password must be at least 10 characters.' : 'Şifre en az 10 karakter olmalı.');
  if(!meta.rules.case) throw new Error(lang==='en' ? 'Password must include both uppercase and lowercase letters.' : 'Şifre büyük ve küçük harf içermeli.');
  if(!meta.rules.number) throw new Error(lang==='en' ? 'Password must include at least one number.' : 'Şifre en az 1 rakam içermeli.');
  if(!meta.rules.special) throw new Error(lang==='en' ? 'Password must include at least one special character.' : 'Şifre en az 1 özel karakter içermeli.');
  if(context.confirm !== undefined && !meta.rules.match) throw new Error(lang==='en' ? 'Passwords do not match.' : 'Şifreler aynı değil.');
  if(!meta.rules.common) throw new Error(lang==='en' ? 'Choose a less predictable password.' : 'Daha zor tahmin edilen bir şifre seç.');
  return meta;
}

function bindAuthEnhancements(){
  document.querySelectorAll('.authField .input').forEach(input=>{
    if(input.dataset.authBound === '1') return;
    input.dataset.authBound = '1';
    const field = input.closest('.authField');
    input.addEventListener('focus', ()=>field?.classList.add('is-focused'));
    input.addEventListener('blur', ()=>field?.classList.remove('is-focused'));
  });

  document.querySelectorAll('[data-toggle-password]').forEach(btn=>{
    if(btn.dataset.bound === '1') return;
    btn.dataset.bound = '1';
    btn.addEventListener('click', ()=>{
      const input = $(btn.dataset.togglePassword || '');
      if(!input) return;
      const hidden = input.type === 'password';
      input.type = hidden ? 'text' : 'password';
      btn.textContent = hidden ? t('hidePassword') : t('showPassword');
    });
  });

  const emailInput = $('regEmail');
  const schoolInput = $('regSchool');
  const nameInput = $('regName');
  const passInput = $('regPass');
  const yearInput = $('regYear');

  if(emailInput && !emailInput.dataset.liveBound){
    emailInput.dataset.liveBound = '1';
    emailInput.addEventListener('input', ()=>{ updateAuthFieldState(emailInput, emailInput.value.trim() ? isValidEmail(emailInput.value) : null); renderPasswordStrength(); });
  }
  if(schoolInput && !schoolInput.dataset.liveBound){
    schoolInput.dataset.liveBound = '1';
    schoolInput.addEventListener('input', ()=>updateAuthFieldState(schoolInput, schoolInput.value.trim() ? isValidSchoolName(schoolInput.value) : null));
  }
  if(nameInput && !nameInput.dataset.liveBound){
    nameInput.dataset.liveBound = '1';
    nameInput.addEventListener('input', ()=>{ updateAuthFieldState(nameInput, nameInput.value.trim().length >= 3 ? true : null); renderPasswordStrength(); });
  }
  if(passInput && !passInput.dataset.liveBound){
    passInput.dataset.liveBound = '1';
    passInput.addEventListener('input', renderPasswordStrength);
  }
  if(regPassConfirm && !regPassConfirm.dataset.liveBound){
    regPassConfirm.dataset.liveBound = '1';
    regPassConfirm.addEventListener('input', renderPasswordStrength);
  }
  if(yearInput && !yearInput.dataset.liveBound){
    yearInput.dataset.liveBound = '1';
    yearInput.addEventListener('input', ()=>{
      const now = new Date().getFullYear();
      const val = yearInput.value.trim();
      const gy = Number(val);
      updateAuthFieldState(yearInput, val ? (Number.isInteger(gy) && gy >= 1995 && gy <= now) : null);
    });
  }

  const loginEmail = $('loginEmail');
  const loginPass = $('loginPass');
  if(loginEmail && !loginEmail.dataset.liveBound){
    loginEmail.dataset.liveBound = '1';
    loginEmail.addEventListener('input', ()=>updateAuthFieldState(loginEmail, loginEmail.value.trim() ? isValidEmail(loginEmail.value) : null));
    loginEmail.addEventListener('keydown', (e)=>{ if(e.key === 'Enter') btnLogin?.click(); });
  }
  if(loginPass && !loginPass.dataset.liveBound){
    loginPass.dataset.liveBound = '1';
    loginPass.addEventListener('keydown', (e)=>{
      if(e.getModifierState && e.getModifierState('CapsLock') && capsLockHint) capsLockHint.textContent = lang === 'en' ? 'Caps Lock is on.' : 'Caps Lock açık.';
      else if(capsLockHint) capsLockHint.textContent = '';
      if(e.key === 'Enter') btnLogin?.click();
    });
    loginPass.addEventListener('keyup', (e)=>{ if(capsLockHint && !(e.getModifierState && e.getModifierState('CapsLock'))) capsLockHint.textContent = ''; });
  }
  if(yearInput && !yearInput.dataset.enterBound){
    yearInput.dataset.enterBound = '1';
    yearInput.addEventListener('keydown', (e)=>{ if(e.key === 'Enter') btnRegister?.click(); });
  }
  const forgotNew = $('forgotNewPass');
  if(forgotNew && !forgotNew.dataset.enterBound){
    forgotNew.dataset.enterBound = '1';
    forgotNew.addEventListener('keydown', (e)=>{ if(e.key === 'Enter') $('btnDoReset')?.click(); });
  }
  renderPasswordStrength();
}

btnRegister.onclick = async ()=>{
  try{
    setMsg(regMsg,"");
    const full_name = $("regName").value.trim();
    const email = $("regEmail").value.trim().toLowerCase();
    const password = $("regPass").value;
    const password_confirm = regPassConfirm?.value || '';
    const school = $("regSchool").value.trim();
    const class_label = $("regClass")?.value?.trim() || "";
    const grad_year = $("regYear").value.trim();
    const now = new Date().getFullYear();
    const gy = Number(grad_year);
    if(full_name.length < 3) throw new Error(lang==='en' ? 'Enter your full name.' : 'Ad soyad gir.');
    if(!isValidEmail(email)) throw new Error(lang==='en' ? 'Enter a valid email address. Any domain is okay.' : 'Geçerli bir e-posta gir. Her alan adı kullanılabilir.');
    if(!isValidSchoolName(school)) throw new Error(lang==='en' ? 'Enter a valid school name.' : 'Geçerli bir okul adı gir.');
    validatePasswordBeforeSubmit(password, {email, fullName: full_name, confirm: password_confirm});
    if(!grad_year) throw new Error(lang==='en' ? 'Graduation year is required.' : 'Mezuniyet yılı zorunlu.');
    if(!Number.isInteger(gy) || gy < 1995 || gy > now) throw new Error(lang==='en' ? `Graduation year must be between 1995 and ${now}.` : `Mezuniyet yılı 1995 ile ${now} arasında olmalı.`);
    const d = await api("register","POST",{full_name,email,password,school,class_label,grad_year});
    if(d.token) setToken(d.token);
    setMe(d.user);
    activateUserSession(d.user);
    if(Number(d.user?.is_admin) === 1 && new URLSearchParams(location.search).get('fromAdmin') !== '1'){ window.location.href = 'admin.html'; return; }
    await refreshStats();
    await loadUsers();
    homeEntrancePending = true;
    switchView("dashboard");
    await loadDashboard();
    maybeShowFirstWelcome(d.user);
  }catch(e){ setMsg(regMsg, e.message); }
};

if(meBadge){
  meBadge.onclick = openMyProfileFromTopbar;
  meBadge.addEventListener("keydown", (e)=>{
    if(e.key === "Enter" || e.key === " "){
      e.preventDefault();
      openMyProfileFromTopbar();
    }
  });
}

btnLogout.onclick = async ()=>{
  try{ await api("logout","POST",{}); }catch(_){}
  setToken(null);
  clearUserSessionState();
  homeEntrancePending = true;
  me = null; selectedUser = null;
  applyLanguage();
showAuth();
};

// Forgot password modal
btnForgot.onclick = ()=>{
  forgotMsg.textContent="";
  $("forgotEmail").value = $("loginEmail").value || "";
  $("forgotNewPass").value = "";
  forgotModal.classList.remove("hidden");
};
btnCloseForgot.onclick = ()=>forgotModal.classList.add("hidden");
forgotModal.addEventListener("click",(e)=>{ if(e.target===forgotModal) forgotModal.classList.add("hidden"); });
btnDoReset.onclick = async ()=>{
  try{
    setMsg(forgotMsg,"");
    const email = $("forgotEmail").value.trim().toLowerCase();
    const new_password = $("forgotNewPass").value;
    if(!isValidEmail(email)) throw new Error(lang==='en' ? 'Enter a valid email address.' : 'Geçerli bir e-posta gir.');
    validatePasswordBeforeSubmit(new_password, {email});
    await api("reset_password","POST",{email,new_password});
    setMsg(forgotMsg, lang==='en' ? '✅ Password updated. You can log in now.' : '✅ Şifre değişti. Giriş yapabilirsin.');
  }catch(e){ setMsg(forgotMsg, e.message); }
};

// Search debounce
let __searchTimer = null;
search.oninput = ()=>{
  clearTimeout(__searchTimer);
  __searchTimer = setTimeout(()=>loadUsers().catch(e=>setMsg(appMsg,e.message)), 250);
};
filterSchool.oninput = search.oninput;
filterYear.onchange = ()=>loadUsers().catch(e=>setMsg(appMsg,e.message));

// Legacy send
btnLegacySend.onclick = async ()=>{
  try{
    setMsg(legacyMsg,"");
    const message = legacyInput.value.trim();
    if(!message) throw new Error(t("writeMessageErr"));
    await api("legacy_post","POST",{message});
    legacyInput.value="";
    await loadLegacy();
  }catch(e){ setMsg(legacyMsg,e.message); }
};
legacyInput.addEventListener("keydown",(ev)=>{
  if(ev.key==="Enter"){ ev.preventDefault(); btnLegacySend.click(); }
});

// Poll create
btnCreatePoll.onclick = async ()=>{
  try{
    setMsg(pollMsg,"");
    const q = pollQ.value.trim();
    const opts = [pollO1.value.trim(), pollO2.value.trim(), pollO3.value.trim(), pollO4.value.trim()].filter(Boolean);
    await api("poll_create","POST",{question:q, options: opts});
    pollQ.value=""; pollO1.value=""; pollO2.value=""; pollO3.value=""; pollO4.value="";
    setMsg(pollMsg,"✅ Anket yayınlandı.");
    await loadLegacy();
  }catch(e){ setMsg(pollMsg, e.message); }
};


let gossipMode = "all";
let currentConversationId = null;
let currentDmThreadKind = "direct";
let currentDmThreadMeta = null;
let dmAfterId = 0;
let dmPollTimer = null;
let psyLoaded = false;
let dmAllItems = [];
let dmOtherSeenId = 0;
let dmReplyTo = null;
let dmTypingTimer = null;
let dmTypingPingTimer = null;
let dmSearchTimer = null;
let dmVoiceRecorder = null;
let dmVoiceChunks = [];
let dmVoiceRecording = false;
let dmPendingVoiceBlob = null;
let dmPendingVoiceUrl = "";
let dmCallState = null;
let dmCallPollTimer = null;
let dmCallLastSignalId = 0;
let dmIncomingOfferIds = new Set();
let dmHandledCallIds = new Set();
let dmItemsCache = [];
let dmGroupCandidatesCache = [];
let profileBadgeState = { follow_requests:0, dm_unread:0 };


function isMyDmMessage(msg){
  if(!msg || !me) return false;
  const myId = Number(me.id || 0);
  const sid = Number(msg.sender_id || msg.user_id || msg.from_user_id || 0);
  const mineFlag = msg.is_mine === true || msg.is_me === true || Number(msg.is_mine||0)===1 || Number(msg.mine||0)===1;
  const myName = String(me.full_name || "").trim().toLowerCase();
  const senderName = String(msg.sender_name || msg.full_name || "").trim().toLowerCase();
  return mineFlag || (myId>0 && sid===myId) || (!!myName && senderName===myName);
}

function buildDmReplySnippet(itemsById, msg){
  if(msg.reply_to_id == null) return "";
  const ref = itemsById.get(msg.reply_to_id);
  if(!ref) return `<div class="replySnippet muted">${t("dmReplyTo")}</div>`;
  const who = (me && ref.sender_id===me.id) ? t("youLabel") : (ref.sender_name || t("someoneLabel"));
  const body = ref.deleted_at ? `[${t("deletedLabel")}]` : (ref.body ? ref.body : (ref.audio_url ? `[sesli mesaj]` : (ref.photo_url ? `[${t("photoLabel")}]` : "")));
  return `<div class="replySnippet"><b>${escapeHtml(who)}</b>: ${escapeHtml(body)}</div>`;
}

function renderDmChat(container, items, myId){
  const map = new Map();
  for(const it of items){ map.set(it.id, it); }

  let lastSentId = 0;
  for(const it of items){
    if(myId && it.sender_id===myId && !it.deleted_at){ lastSentId = it.id; }
  }

  container.innerHTML = items.map(it=>{
    const isMe = isMyDmMessage(it) || (myId && Number(it.sender_id||0)===Number(myId));
    const name = it.sender_name || (isMe ? "Sen" : "Biri");
    const edited = it.edited_at ? ' • düzenlendi' : '';
    const meta = `<div class="msgMeta">${escapeHtml(name)} • ${escapeHtml(it.created_at || "")}${edited}</div>`;

    let body = "";
    if(it.deleted_at){
      body = `<i class="muted">[${t("deletedLabel")}]</i>`;
    }else{
      body += buildDmReplySnippet(map, it);
      if(it.body) body += `<div>${escapeHtml(it.body)}</div>`;
      if(it.photo_url) body += `<div style="margin-top:6px"><img src="${escapeHtml(resolveUrl(it.photo_url))}" onerror="this.closest('div').remove()" style="max-width:260px;border-radius:12px;border:1px solid rgba(255,255,255,0.12)"/></div>`;
      if(it.audio_url) body += `<div class="dmAudioBubble"><audio controls preload="metadata" src="${escapeHtml(resolveUrl(it.audio_url))}"></audio></div>`;
    }

    const actions = `
      <div class="actions">
        <button type="button" class="pill" data-act="reply" data-id="${it.id}">${t("reply")}</button>
        ${isMe && !it.deleted_at ? `<button type="button" class="pill" data-act="edit" data-id="${it.id}">${t("edit")}</button>` : ``}
        ${isMe ? `<button type="button" class="pill danger" data-act="delete" data-id="${it.id}">${t("delete")}</button>` : ``}
      </div>
    `;

    const seen = (isMe && it.id===lastSentId && dmOtherSeenId>=it.id) ? `<div class="seen">${t("seenLabel")}</div>` : "";

    return `<div class="msgRow">
      <div class="msgBubble msg ${isMe?'me':''}" data-mid="${it.id}">
        ${meta}
        ${body}
        <div class="metaRow">${actions}</div>
        ${seen}
      </div>
    </div>`;
  }).join("");
  container.scrollTop = container.scrollHeight;
}

function renderChat(container, items, myId){
  container.innerHTML = items.map(it=>{
    const isMe = myId && (it.sender_id===myId || it.role==='user');
    const name = it.sender_name || (it.role==='user' ? t('youLabel') : 'MEra');
    const meta = `<div class="msgMeta">${escapeHtml(name)} • ${escapeHtml(it.created_at || "")}</div>`;
    let body = "";
    if(it.deleted_at){ body = `<i class="muted">[${t("deletedLabel")}]</i>`; }
    else{
      if(it.body) body += `<div>${escapeHtml(it.body)}</div>`;
      if(it.photo_url) body += `<div style="margin-top:6px"><img src="${escapeHtml(resolveUrl(it.photo_url))}" onerror="this.closest('div').remove()" style="max-width:260px;border-radius:12px;border:1px solid rgba(255,255,255,0.12)"/></div>`;
      if(it.content) body += `<div>${escapeHtml(it.content)}</div>`;
    }
    return `<div class="msgRow"><div class="msgBubble ${isMe?'me':''}">${meta}${body}</div></div>`;
  }).join("");
  container.scrollTop = container.scrollHeight;
}

// ---- Gossip ----
function renderGossip(items){
  gossipList.innerHTML = items.map(p=>{
    const who = p.user?.full_name || "Biri";
    const vis = p.visibility === 'school' ? '🏫 Okulum' : '🌍 Genel';
    const catMap={general:'✨ Genel',teacher:'👩‍🏫 Öğretmen',school:'🏫 Okul gündemi',confession:'💬 İtiraf',memory:'📸 Anı',question:'❓ Soru'};
    const cat=catMap[p.category||'general']||'✨ Genel';
    const ems = ['❤️','😂','🔥','🎉','👏','😮'];
    const reacts = ems.map(e=>{
      const cnt = p.reactions?.[e] || 0;
      const active = (p.my_reactions||[]).includes(e) ? 'active' : '';
      return `<button class="btn emoji ${active}" data-act="greact" data-type="post" data-id="${p.id}" data-emoji="${e}">${e} ${cnt}</button>`;
    }).join(" ");
    return `
      <div class="card" style="margin-top:10px">
        <div class="fwHead">
          <div><b>${escapeHtml(who)}</b> <span class="muted small">• ${escapeHtml(vis)} • ${escapeHtml(cat)} • ${escapeHtml(p.created_at)}</span></div>
          <button class="btn" data-act="gcomments" data-id="${p.id}">Yorumlar (${p.comment_count||0})</button>
        </div>
        <div style="margin-top:8px;white-space:pre-wrap">${escapeHtml(p.content)}</div>
        <div class="fwActions">${reacts}</div>
        <div class="hidden" id="gcm_${p.id}" style="margin-top:10px">
          <div class="muted small" id="gcmmsg_${p.id}"></div>
          <div id="gcmlist_${p.id}"></div>
          <div style="display:flex;gap:8px;margin-top:8px">
            <input class="input" id="gcm_in_${p.id}" placeholder="Yorum yaz..."/>
            <button class="btn primary" data-act="gcomment" data-id="${p.id}">${t('send')}</button>
          </div>
        </div>
      </div>
    `;
  }).join("");
}

async function loadGossip(){
  const d = await api("gossip_list","GET",{mode:gossipMode, sort:(gossipSort?.value||'new'), category:(gossipFilterCategory?.value||'all')});
  renderGossip(d.items || []);
}

btnGossipPost.onclick = async ()=>{
  try{
    setMsg(gossipMsg,"");
    const content = gossipText.value.trim();
    const visibility = gossipVisibility.value;
    await api("gossip_post","POST",{content, visibility, category:(gossipCategory?.value||"general")});
    gossipText.value="";
    await loadGossip();
    setMsg(gossipMsg,"✅ Paylaşıldı.");
  }catch(e){ setMsg(gossipMsg,e.message); }
};

gossipList.addEventListener("click", async (e)=>{
  const t = e.target.closest("button");
  if(!t) return;
  const act = t.dataset.act;
  if(act==="greact"){
    try{
      await api("gossip_react","POST",{target_type:t.dataset.type, target_id:parseInt(t.dataset.id), emoji:t.dataset.emoji});
      await loadGossip();
    }catch(err){ setMsg(gossipMsg, err.message); }
  }
  if(act==="gcomments"){
    const pid = parseInt(t.dataset.id);
    const box = document.getElementById("gcm_"+pid);
    box.classList.toggle("hidden");
    if(!box.classList.contains("hidden")){
      const dd = await api("gossip_comments","GET",{post_id:pid});
      const list = document.getElementById("gcmlist_"+pid);
      const ems = ['❤️','😂','🔥','🎉','👏','😮'];
      list.innerHTML = (dd.items||[]).map(c=>{
        const reacts = ems.map(em=>{
          const cnt = c.reactions?.[em] || 0;
          const active = (c.my_reactions||[]).includes(em) ? 'active' : '';
          return `<button class="btn emoji ${active}" data-act="greact" data-type="comment" data-id="${c.id}" data-emoji="${em}">${em} ${cnt}</button>`;
        }).join(" ");
        return `<div style="margin-top:8px;padding:8px;border:1px solid rgba(255,255,255,0.10);border-radius:12px">
          <div class="muted small"><b>${escapeHtml(c.user?.full_name||"")}</b> • ${escapeHtml(c.created_at||"")}</div>
          <div style="white-space:pre-wrap;margin-top:4px">${escapeHtml(c.content)}</div>
          <div class="fwActions">${reacts}</div>
        </div>`;
      }).join("");
    }
  }
  if(act==="gcomment"){
    const pid = parseInt(t.dataset.id);
    const inp = document.getElementById("gcm_in_"+pid);
    const content = inp.value.trim();
    if(!content) return;
    await api("gossip_comment","POST",{post_id:pid, content});
    inp.value="";
    // reload comments
    const dd = await api("gossip_comments","GET",{post_id:pid});
    const list = document.getElementById("gcmlist_"+pid);
    list.innerHTML = (dd.items||[]).map(c=>`<div style="margin-top:8px;padding:8px;border:1px solid rgba(255,255,255,0.10);border-radius:12px">
      <div class="muted small"><b>${escapeHtml(c.user?.full_name||"")}</b> • ${escapeHtml(c.created_at||"")}</div>
      <div style="white-space:pre-wrap;margin-top:4px">${escapeHtml(c.content)}</div>
    </div>`).join("");
    await loadGossip(); // update counts
  }
});

if(gossipSort) gossipSort.onchange = loadGossip;
if(gossipFilterCategory) gossipFilterCategory.onchange = loadGossip;
document.querySelectorAll('[data-gossip-mode]').forEach(btn=>btn.onclick=async()=>{ gossipMode=btn.dataset.gossipMode||'all'; document.querySelectorAll('[data-gossip-mode]').forEach(b=>b.classList.toggle('active',b===btn)); await loadGossip(); });

// ---- DM ----
function currentDmIsGroup(){ return currentDmThreadKind === "group"; }

function dmThreadTitle(item){
  if(!item) return "Sohbet";
  if((item.thread_kind || "direct") === "group") return item.title || item.group?.title || item.with?.full_name || "Grup";
  return item.with?.full_name || "Sohbet";
}

function dmThreadAvatarData(item){
  if(!item) return { full_name:"?" };
  if((item.thread_kind || "direct") === "group") return { full_name: dmThreadTitle(item), photo_url: item.group?.photo_url || item.with?.photo_url || "" };
  return item.with || { full_name: dmThreadTitle(item) };
}

function dmGroupPreviewNames(item){
  const arr = Array.isArray(item?.group?.members_preview) ? item.group.members_preview : [];
  return arr.slice(0,4).map(x=>String(x.full_name || '').trim()).filter(Boolean);
}

function isAdminUser(u){ return !!u && (Number(u.is_admin||0)===1 || String(u.email||'').toLowerCase()==='admin@mera.com'); }

function dmTargetCallAllowed(item){
  if(!item || (item.thread_kind || 'direct') === 'group') return false;
  const u = item.with || {};
  return !(isAdminUser(u) && Number(u.admin_call_allowed ?? 1) !== 1);
}

function dmCurrentMuted(){
  return !!(currentDmThreadMeta && Number(currentDmThreadMeta.is_muted || 0) === 1);
}

function updateDmMuteButton(){
  if(!btnDmMute) return;
  const can = !!(currentConversationId && !currentDmIsGroup());
  const muted = dmCurrentMuted();
  btnDmMute.disabled = !can;
  btnDmMute.classList.toggle('disabled', !can);
  btnDmMute.textContent = muted ? '🔕 Sesi aç' : '🔔 Sessize al';
  btnDmMute.title = muted ? 'Bu sohbetin bildirimlerini aç' : 'Bu sohbetin bildirimlerini kapat';
}

function updateDmCallButtons(){
  const allowed = !!(currentConversationId && !currentDmIsGroup() && dmTargetCallAllowed(currentDmThreadMeta));
  [btnDmAudioCall, btnDmVideoCall].forEach(btn=>{
    if(!btn) return;
    btn.disabled = !allowed;
    btn.title = allowed ? (btn.id === 'btnDmVideoCall' ? 'Görüntülü konuşma' : 'Sesli arama') : 'Bu admin şu anda aranamaz.';
    btn.classList.toggle('disabled', !allowed);
  });
}

function setDmHeader(item){
  if(!item) return;
  if((item.thread_kind || "direct") === "group"){
    dmWith.textContent = `${t('groupTag')} • ${dmThreadTitle(item)}`;
  }else{
    dmWith.textContent = `${t('dm')} • ${dmThreadTitle(item)}`;
    if(isAdminUser(item.with) && Number(item.with?.admin_call_allowed ?? 1) !== 1) dmWith.textContent += ' • Aranamaz';
  }
  updateDmCallButtons();
  updateDmMuteButton();
}

async function openDmThreadItem(item, showPrompt=""){
  if(!item) return;
  currentDmThreadKind = item.thread_kind || "direct";
  currentConversationId = Number(item.group_id || item.conversation_id || 0) || null;
  currentDmThreadMeta = item;
  dmAfterId = 0;
  dmAllItems = [];
  dmOtherSeenId = 0;
  clearPendingDmVoice();
  clearDmReply();
  dmTyping.textContent = "";
  dmSearch.value = "";
  dmChat.dataset.items = JSON.stringify([]);
  setDmHeader(item);
  setActiveDmThread(String(currentConversationId), currentDmThreadKind);
  await loadDmMessages(true);
  await refreshDmMeta();
  if(typeof loadDmGroupExtras === "function") loadDmGroupExtras().catch(()=>{});
  startDmPolling();
  refreshProfileBadges();
  if(showPrompt) setMsg(dmMsg, showPrompt);
}

function closeDmGroupModal(){
  if(dmGroupModal) dmGroupModal.classList.add('hidden');
}

function openDmGroupModal(){
  if(!dmGroupModal) return;
  dmGroupModal.classList.remove('hidden');
  if(dmGroupName) dmGroupName.value = '';
  if(dmGroupDesc) dmGroupDesc.value = '';
  if(dmGroupSpotify) dmGroupSpotify.value = '';
  if(dmGroupPhoto) dmGroupPhoto.value = '';
  if(dmGroupSearch) dmGroupSearch.value = '';
  setMsg(dmGroupMsg, '');
  loadDmGroupCandidates().catch(err=>setMsg(dmGroupMsg, err.message || 'Hata'));
}

function renderDmGroupCandidates(){
  if(!dmGroupCandidates) return;
  const q = String(dmGroupSearch?.value || '').trim().toLowerCase();
  const checked = new Set(Array.from(dmGroupCandidates.querySelectorAll('input[type="checkbox"]:checked')).map(el=>Number(el.value || 0)));
  const items = (dmGroupCandidatesCache || []).filter(u=>{
    if(!q) return true;
    return String(u.full_name || '').toLowerCase().includes(q) || String(u.school || '').toLowerCase().includes(q);
  });
  if(!items.length){
    dmGroupCandidates.innerHTML = `<div class="muted small">${t('groupNoCandidates')}</div>`;
    return;
  }
  dmGroupCandidates.innerHTML = items.map(u=>`<label class="dmGroupCandidate"><div class="dmGroupCandidateMain">${avatarHtml(u)}<div><b>${escapeHtml(u.full_name || '')}</b><div class="dmGroupHint">${escapeHtml(u.school || '—')}</div></div></div><input type="checkbox" value="${Number(u.id || 0)}" ${checked.has(Number(u.id || 0)) ? 'checked' : ''}/></label>`).join('');
}

async function loadDmGroupCandidates(){
  const d = await api('dm_group_candidates');
  dmGroupCandidatesCache = d.items || [];
  renderDmGroupCandidates();
}

function stopDmPolling(){ if(dmPollTimer){ clearInterval(dmPollTimer); dmPollTimer=null; } }

function dmStatusText(user, isTyping=false){
  if(isTyping) return t("typingNow");
  if(user?.online) return t("online");
  if(user?.last_seen){
    const raw = String(user.last_seen).replace(" ", "T") + "Z";
    const dt = new Date(raw);
    if(!Number.isNaN(dt.getTime())){
      const diffMin = Math.max(0, Math.round((Date.now() - dt.getTime()) / 60000));
      if(diffMin < 1) return t("online");
      if(diffMin < 60) return `${t("lastSeen")} • ${diffMin} dk`;
      const diffHr = Math.round(diffMin / 60);
      if(diffHr < 24) return `${t("lastSeen")} • ${diffHr} sa`;
      const diffDay = Math.round(diffHr / 24);
      return `${t("lastSeen")} • ${diffDay} g`;
    }
  }
  return t("lastSeen") + " • —";
}

function dmStatusDot(user, isTyping=false){
  const cls = isTyping ? "typing" : (user?.online ? "online" : "offline");
  return `<span class="dmStatusDot ${cls}"></span>`;
}

function dmMetaLine(user, isTyping=false){
  return `${dmStatusDot(user, isTyping)}<span>${escapeHtml(dmStatusText(user, isTyping))}</span>`;
}

function renderDmList(items){
  dmItemsCache = items || [];
  dmList.innerHTML = (items||[]).map(c=>{
    const kind = c.thread_kind || 'direct';
    const isGroup = kind === 'group';
    const name = dmThreadTitle(c);
    const last = c.last_message ? escapeHtml(c.last_message) : (isGroup ? t('groupStart') : t('startChat'));
    const muted = Number(c.is_muted || 0) === 1;
    const unread = Number(c.unread_count||0) > 0 ? `<span class="miniBadge dmListBadge">${Number(c.unread_count||0)}</span>` : ``;
    const muteIcon = muted ? `<span class="dmMuteIcon" title="Sessizde">🔕</span>` : ``;
    const avatar = avatarHtml(dmThreadAvatarData(c));
    const previewNames = dmGroupPreviewNames(c).map(n=>n.split(/\s+/)[0]).join(', ');
    const status = isGroup
      ? `<div class="dmThreadMetaLine"><span class="dmThreadTag">${t('groupTag')}</span><span>${Number(c.group?.member_count||0)} ${t('groupCount')}</span>${previewNames ? `<span>${escapeHtml(previewNames)}</span>` : ``}</div>`
      : `<div class="dmThreadStatus">${dmMetaLine(c.with, false)}</div>`;
    return `<button class="dmThreadCard ${muted ? 'mutedThread' : ''}" type="button" data-kind="${kind}" data-cid="${c.conversation_id||0}" data-uid="${c.with?.id||0}" data-name="${escapeHtml(name)}">
      <div class="dmThreadAvatar">${avatar}</div>
      <div class="dmThreadBody">
        <div class="dmListHead"><b>${escapeHtml(name)}</b>${muteIcon}${unread}</div>
        ${status}
        <div class="dmThreadPreview">${last}</div>
      </div>
    </button>`;
  }).join("");
}

function setActiveDmThread(identifier, kind='direct'){
  dmList.querySelectorAll('.dmThreadCard').forEach(el=>{
    const sameKind = String(el.dataset.kind || 'direct') === String(kind || 'direct');
    const sameId = String(el.dataset.cid||'0')===String(identifier||'');
    el.classList.toggle('active', !!(sameKind && sameId));
  });
}

async function loadDM(){
  stopDmPolling();
  currentConversationId = null;
  currentDmThreadKind = 'direct';
  currentDmThreadMeta = null;
  dmAfterId = 0;
  dmWith.textContent = t('chooseChat');
  dmChat.innerHTML = "";
  updateDmMuteButton();
  dmAllItems = [];
  dmOtherSeenId = 0;
  clearPendingDmVoice();
  clearDmReply();
  dmTyping.textContent = "";
  dmSearch.value = "";

  const list = await api("dm_list");
  const items = list.items || [];
  renderDmList(items);
  refreshProfileBadges();
  if(!items.length){
    dmWith.textContent = t('chooseChat');
    dmChat.innerHTML = `<div class="dmEmptyState"><div class="dmEmptyIcon">✉️</div><p class="muted">${t("noDmYet")}</p></div>`;
    return;
  }
  await openDmThreadItem(items[0]);
}

async function refreshDmMeta(){
  if(!currentConversationId) return;
  const statusEl = $("dmStatusText");
  if(currentDmIsGroup()){
    let typingUsers = [];
    try{
      const ts = await api('dm_group_typing_get','GET',{group_id: currentConversationId});
      typingUsers = ts.typing_users || [];
    }catch(_){ }
    const group = currentDmThreadMeta?.group || {};
    const preview = dmGroupPreviewNames(currentDmThreadMeta).map(n=>n.split(/\s+/)[0]).join(', ');
    const pieces = [`<span class="dmThreadTag">${escapeHtml(t('groupTag'))}</span>`, `<span>${Number(group.member_count||0)} ${escapeHtml(t('groupCount'))}</span>`];
    if(preview) pieces.push(`<span>${escapeHtml(preview)}</span>`);
    if(group.spotify_link) pieces.push(`<a href="${escapeHtml(resolveUrl(group.spotify_link))}" target="_blank" rel="noreferrer">Spotify</a>`);
    if(statusEl) statusEl.innerHTML = pieces.join(' ');
    dmTyping.textContent = typingUsers.length ? `${typingUsers.map(x=>String(x.full_name||'').split(/\s+/)[0]).filter(Boolean).join(', ')} ${t('groupTypingNow')}` : '';
    if(typeof loadDmGroupExtras === 'function') loadDmGroupExtras().catch(()=>{});
    return;
  }
  const dmGroupExtras = $('dmGroupExtras');
  if(dmGroupExtras) dmGroupExtras.classList.add('hidden');
  let otherUser = null;
  try{
    const rs = await api("dm_read_status","GET",{conversation_id: currentConversationId});
    dmOtherSeenId = rs.other?.last_seen_message_id || 0;
    otherUser = rs.other_user || null;
  }catch(_){ }
  let isTyping = false;
  try{
    const ts = await api("dm_typing_get","GET",{conversation_id: currentConversationId});
    isTyping = !!ts.is_typing;
    if(ts.other_user) otherUser = ts.other_user;
  }catch(_){ }
  if(statusEl) statusEl.innerHTML = dmMetaLine(otherUser, isTyping);
  dmTyping.textContent = isTyping ? t("typingNow") : "";
}

function startDmPolling(){
  stopDmPolling();
  let dmPollTick = 0;
  dmPollTimer = setInterval(async ()=>{
    await loadDmMessages(false);
    await refreshDmMeta();
    dmPollTick++;
    if(dmPollTick % 2 === 0){
      try{
        const list = await api("dm_list");
        renderDmList(list.items || []);
        if(currentConversationId) setActiveDmThread(String(currentConversationId), currentDmThreadKind);
      }catch(_){ }
    }
  }, 2500);
}

async function loadDmMessages(forceFull){
  if(!currentConversationId) return;
  if(forceFull){ dmAfterId = 0; dmAllItems = []; }
  let d = {items:[]};
  if(currentDmIsGroup()){
    d = await api('dm_group_messages','GET',{group_id: currentConversationId, after_id: dmAfterId});
    if(d.group){
      currentDmThreadMeta = Object.assign({}, currentDmThreadMeta || {}, { thread_kind:'group', group:d.group, title:d.group.title, with:{id:d.group.id, full_name:d.group.title, photo_url:d.group.photo_url || ''} });
      setDmHeader(currentDmThreadMeta);
    }
  }else{
    d = await api("dm_messages","GET",{conversation_id: currentConversationId, after_id: dmAfterId});
  }
  const items = d.items || [];
  if(items.length){
    dmAfterId = items[items.length-1].id;
    dmAllItems = dmAllItems.concat(items);
  }
  applyDmSearch();
  if(dmAfterId>0){
    if(currentDmIsGroup()) api('dm_group_mark_seen','POST',{group_id: currentConversationId, last_seen_message_id: dmAfterId}).catch(()=>{});
    else api("dm_mark_seen","POST",{conversation_id: currentConversationId, last_seen_message_id: dmAfterId}).catch(()=>{});
  }
}

function applyDmSearch(){
  const q = (dmSearch.value||"").trim().toLowerCase();
  let shown = dmAllItems;
  if(q){
    shown = dmAllItems.filter(m=>{
      const body = (m.body||"").toLowerCase();
      return body.includes(q);
    });
  }
  dmChat.dataset.items = JSON.stringify(shown);
  renderDmChat(dmChat, shown, me?.id);
}

dmList.addEventListener("click", async (e)=>{
  const itemEl = e.target.closest(".dmThreadCard");
  if(!itemEl) return;
  const kind = itemEl.dataset.kind || 'direct';
  const cid = parseInt(itemEl.dataset.cid || '0');
  const uid = parseInt(itemEl.dataset.uid || '0');
  const item = (dmItemsCache || []).find(x => String(x.thread_kind || 'direct') === String(kind) && Number(x.conversation_id || x.group_id || 0) === Number(cid));
  if(kind === 'group'){
    if(item) await openDmThreadItem(item);
    return;
  }
  if(!cid && uid){
    try{ await openDmWithUser(uid, itemEl.dataset.name || ""); }catch(err){ setMsg(dmMsg, err.message || 'DM açılamadı.'); }
    return;
  }
  if(item) await openDmThreadItem(item);
});



function syncDmAttachmentUi(){
  const file = dmPhoto?.files && dmPhoto.files[0] ? dmPhoto.files[0] : null;
  if(dmAttachmentName) dmAttachmentName.textContent = file ? `📎 ${file.name}` : 'Dosya seçilmedi';
  const attachBtn = document.querySelector('.dmAttachBtn');
  if(attachBtn) attachBtn.classList.toggle('has-file', !!file);
  if(file && dmMsg) setMsg(dmMsg, `📎 ${file.name} seçildi.`);
}

function setDmRecordHint(text=''){
  if(!dmRecordHint) return;
  dmRecordHint.textContent = text || '🎙️ Sesli mesaj için mikrofona bas';
}


function clearPendingDmVoice(){
  dmPendingVoiceBlob = null;
  if(dmPendingVoiceUrl){ try{ URL.revokeObjectURL(dmPendingVoiceUrl); }catch(_){ } }
  dmPendingVoiceUrl = "";
  if(dmVoicePreviewAudio){
    try{ dmVoicePreviewAudio.pause(); }catch(_){ }
    dmVoicePreviewAudio.removeAttribute('src');
    try{ dmVoicePreviewAudio.load(); }catch(_){ }
  }
  if(dmVoicePreview) dmVoicePreview.classList.add('hidden');
  setDmRecordHint();
}

function setPendingDmVoice(blob){
  clearPendingDmVoice();
  if(!blob || !blob.size) return;
  dmPendingVoiceBlob = blob;
  dmPendingVoiceUrl = URL.createObjectURL(blob);
  if(dmVoicePreviewAudio) dmVoicePreviewAudio.src = dmPendingVoiceUrl;
  if(dmVoicePreview) dmVoicePreview.classList.remove('hidden');
  setDmRecordHint("🎧 Sesli mesaj hazır. Dinleyip Gönder'e basabilirsin");
}

async function sendDmAudioBlob(blob){
  if(!currentConversationId) return setMsg(dmMsg, t("selectChatFirst"));
  if(!blob || !blob.size) return;
  const fd = new FormData();
  fd.append(currentDmIsGroup() ? "group_id" : "conversation_id", String(currentConversationId));
  fd.append("body", "");
  if(dmReplyTo) fd.append("reply_to_id", String(dmReplyTo.id));
  fd.append("audio", blob, `voice-${Date.now()}.webm`);
  await api(currentDmIsGroup() ? "dm_group_send" : "dm_send", "POST", fd, true);
  clearDmReply();
  await loadDmMessages(true);
  await refreshDmMeta();
  try{
    const list = await api("dm_list");
    renderDmList(list.items || []);
    if(currentConversationId) setActiveDmThread(String(currentConversationId), currentDmThreadKind);
  }catch(_){ }
}

async function toggleDmVoiceRecord(){
  if(dmVoiceRecording && dmVoiceRecorder){ try{ dmVoiceRecorder.stop(); }catch(_){ } return; }
  if(dmPendingVoiceBlob) clearPendingDmVoice();
  if(!window.MediaRecorder) return setMsg(dmMsg, "Tarayıcı sesli mesaj kaydını desteklemiyor.");
  if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) return setMsg(dmMsg, "Tarayıcı ses kaydını desteklemiyor.");
  if(!currentConversationId) return setMsg(dmMsg, t("selectChatFirst"));
  try{
    const stream = await navigator.mediaDevices.getUserMedia({audio:true});
    dmVoiceChunks = [];
    dmVoiceRecorder = new MediaRecorder(stream);
    dmVoiceRecorder.ondataavailable = e=>{ if(e.data && e.data.size) dmVoiceChunks.push(e.data); };
    dmVoiceRecorder.onerror = ()=>{
      dmVoiceRecording = false;
      if(btnDmVoiceRecord){ btnDmVoiceRecord.classList.remove("recording"); btnDmVoiceRecord.textContent = "🎙️"; btnDmVoiceRecord.title = 'Sesli mesaj başlat / durdur'; }
      setDmRecordHint();
      setMsg(dmMsg, "Ses kaydı sırasında bir hata oluştu.");
      try{ stream.getTracks().forEach(t=>t.stop()); }catch(_){ }
    };
    dmVoiceRecorder.onstop = ()=>{
      dmVoiceRecording = false;
      if(btnDmVoiceRecord){ btnDmVoiceRecord.classList.remove("recording"); btnDmVoiceRecord.textContent = "🎙️"; btnDmVoiceRecord.title = 'Sesli mesaj başlat / durdur'; }
      try{ stream.getTracks().forEach(t=>t.stop()); }catch(_){ }
      const blob = new Blob(dmVoiceChunks, {type: dmVoiceRecorder?.mimeType || "audio/webm"});
      if(blob && blob.size){
        setPendingDmVoice(blob);
        setMsg(dmMsg, "🎧 Sesli mesaj hazır. Dinleyip Gönder'e basınca karşı tarafa gider.");
      }else{
        setDmRecordHint();
        setMsg(dmMsg, "Ses kaydı alınamadı.");
      }
    };
    dmVoiceRecorder.start();
    dmVoiceRecording = true;
    if(btnDmVoiceRecord){ btnDmVoiceRecord.classList.add("recording"); btnDmVoiceRecord.textContent = "⏹️"; btnDmVoiceRecord.title = 'Kaydı durdur'; }
    setDmRecordHint('🔴 Kayıt sürüyor... Bitirmek için tekrar bas');
    setMsg(dmMsg, "Kayıt başladı. Durdurmak için tekrar bas.");
  }catch(e){ setDmRecordHint(); setMsg(dmMsg, "Mikrofon izni alınamadı: " + (e.message || "")); }
}

function dmHandledCallStorageKey(){
  const myId = me && me.id ? String(me.id) : 'guest';
  return `mera_dm_handled_calls_${myId}`;
}

function loadHandledDmCalls(){
  try{
    const raw = localStorage.getItem(dmHandledCallStorageKey());
    const arr = raw ? JSON.parse(raw) : [];
    if(Array.isArray(arr)) dmHandledCallIds = new Set(arr.slice(-80).map(String));
  }catch(_){ dmHandledCallIds = new Set(); }
}

function rememberHandledDmCall(callId){
  if(!callId) return;
  const id = String(callId);
  dmHandledCallIds.add(id);
  try{
    const arr = Array.from(dmHandledCallIds).slice(-80);
    localStorage.setItem(dmHandledCallStorageKey(), JSON.stringify(arr));
  }catch(_){ }
}

function ensureDmCallOverlay(){
  let el = document.getElementById("dmCallOverlay");
  if(el) return el;
  el = document.createElement("div");
  el.id = "dmCallOverlay";
  el.className = "dmCallOverlay hidden";
  el.innerHTML = `
    <div class="dmCallPanel">
      <div class="dmCallHead">
        <div><b id="dmCallTitle">DM araması</b><div class="muted small" id="dmCallStatus">Bağlanıyor...</div></div>
        <button class="btn danger" id="btnDmHangup" type="button">Kapat</button>
      </div>
      <div class="dmCallVideos">
        <video id="dmRemoteVideo" autoplay playsinline></video>
        <video id="dmLocalVideo" autoplay playsinline muted></video>
      </div>
    </div>`;
  document.body.appendChild(el);
  $("btnDmHangup").onclick = ()=>endDmCall(true);
  return el;
}

function showDmCallOverlay(kind, status){
  const el = ensureDmCallOverlay();
  el.classList.remove("hidden");
  const title = $("dmCallTitle");
  const st = $("dmCallStatus");
  if(title) title.textContent = kind === "video" ? "Görüntülü konuşma" : "Sesli arama";
  if(st) st.textContent = status || "Bağlanıyor...";
  const localVideo = $("dmLocalVideo");
  const remoteVideo = $("dmRemoteVideo");
  if(localVideo) localVideo.classList.toggle("audioOnly", kind !== "video");
  if(remoteVideo) remoteVideo.classList.toggle("audioOnly", kind !== "video");
}

function hideDmCallOverlay(){
  const el = $("dmCallOverlay");
  if(el) el.classList.add("hidden");
}

async function dmSendCallSignal(type, payload={}, callId=null){
  if(!currentConversationId) return;
  const cid = callId || dmCallState?.callId || ("call_" + Date.now() + "_" + Math.random().toString(16).slice(2));
  await api("dm_call_signal", "POST", {
    conversation_id: currentConversationId,
    call_id: cid,
    type,
    payload: JSON.stringify(payload || {})
  });
}

function startDmCallSignalPolling(){
  if(dmCallPollTimer) return;
  loadHandledDmCalls();
  fetchDmCallSignals().catch(()=>{});
  dmCallPollTimer = setInterval(fetchDmCallSignals, 1200);
}

function stopDmCallSignalPolling(){
  if(dmCallPollTimer){ clearInterval(dmCallPollTimer); dmCallPollTimer = null; }
}

async function createDmPeer(kind){
  const pc = new RTCPeerConnection({iceServers:[{urls:"stun:stun.l.google.com:19302"}]});
  pc.onicecandidate = e=>{
    if(e.candidate) dmSendCallSignal("candidate", e.candidate.toJSON()).catch(()=>{});
  };
  pc.ontrack = e=>{
    const remote = $("dmRemoteVideo");
    if(remote && e.streams && e.streams[0]) remote.srcObject = e.streams[0];
  };
  const stream = await navigator.mediaDevices.getUserMedia({audio:true, video: kind === "video"});
  stream.getTracks().forEach(track=>pc.addTrack(track, stream));
  const local = $("dmLocalVideo");
  if(local) local.srcObject = stream;
  return {pc, stream};
}

async function startDmCall(kind){
  if(!currentConversationId) return setMsg(dmMsg, t("selectChatFirst"));
  if(currentDmIsGroup()) return setMsg(dmMsg, "Arama şu an yalnızca bire bir DM için açık.");
  if(!navigator.mediaDevices || !window.RTCPeerConnection) return setMsg(dmMsg, "Tarayıcı aramayı desteklemiyor.");
  if(!dmTargetCallAllowed(currentDmThreadMeta)) return setMsg(dmMsg, "Bu admin şu anda aranamaz olarak ayarlı.");
  if(dmCallState) return setMsg(dmMsg, "Zaten açık bir arama var.");
  try{
    showDmCallOverlay(kind, "Aranıyor...");
    const callId = "call_" + Date.now() + "_" + Math.random().toString(16).slice(2);
    const {pc, stream} = await createDmPeer(kind);
    dmCallState = {callId, kind, pc, stream, incoming:false};
    dmCallLastSignalId = 0;
    const offer = await pc.createOffer();
    await pc.setLocalDescription(offer);
    await dmSendCallSignal("offer", {sdp: offer, kind}, callId);
    startDmCallSignalPolling();
  }catch(e){
    endDmCall(false);
    setMsg(dmMsg, "Arama başlatılamadı: " + (e.message || ""));
  }
}

async function acceptDmCall(sig, payload){
  try{
    const kind = payload.kind || "audio";
    showDmCallOverlay(kind, "Gelen arama kabul ediliyor...");
    const {pc, stream} = await createDmPeer(kind);
    dmCallState = {callId:sig.call_id, kind, pc, stream, incoming:true};
    dmCallLastSignalId = Math.max(dmCallLastSignalId, Number(sig.id||0));
    await pc.setRemoteDescription(new RTCSessionDescription(payload.sdp));
    const answer = await pc.createAnswer();
    await pc.setLocalDescription(answer);
    await dmSendCallSignal("answer", {sdp: answer}, sig.call_id);
    startDmCallSignalPolling();
    const st = $("dmCallStatus"); if(st) st.textContent = "Bağlandı";
  }catch(e){
    endDmCall(false);
    setMsg(dmMsg, "Arama kabul edilemedi: " + (e.message || ""));
  }
}

async function handleDmCallSignal(sig){
  let payload = {};
  try{ payload = sig.payload ? JSON.parse(sig.payload) : {}; }catch(_){ payload = {}; }
  if(sig.type === "offer"){
    if(dmCallState || dmIncomingOfferIds.has(sig.call_id) || dmHandledCallIds.has(String(sig.call_id))) return;
    dmIncomingOfferIds.add(sig.call_id);
    const kind = payload.kind || "audio";
    const ok = confirm(`${dmThreadTitle(currentDmThreadMeta)} ${kind === "video" ? "görüntülü konuşma" : "sesli arama"} başlatıyor. Kabul edilsin mi?`);
    rememberHandledDmCall(sig.call_id);
    if(ok) await acceptDmCall(sig, payload);
    else await dmSendCallSignal("decline", {}, sig.call_id);
    return;
  }
  if(!dmCallState || sig.call_id !== dmCallState.callId) return;
  if(sig.type === "answer" && payload.sdp){
    await dmCallState.pc.setRemoteDescription(new RTCSessionDescription(payload.sdp));
    const st = $("dmCallStatus"); if(st) st.textContent = "Bağlandı";
  }else if(sig.type === "candidate" && payload.candidate){
    try{ await dmCallState.pc.addIceCandidate(new RTCIceCandidate(payload)); }catch(_){ }
  }else if(sig.type === "hangup" || sig.type === "decline"){
    rememberHandledDmCall(sig.call_id);
    endDmCall(false);
    setMsg(dmMsg, sig.type === "decline" ? "Arama reddedildi." : "Arama kapatıldı.");
  }
}

async function fetchDmCallSignals(){
  if(!currentConversationId) return;
  try{
    const params = {conversation_id: currentConversationId, after_id: dmCallLastSignalId};
    if(dmCallState?.callId) params.call_id = dmCallState.callId;
    const d = await api("dm_call_fetch", "GET", params);
    for(const sig of (d.items || [])){
      dmCallLastSignalId = Math.max(dmCallLastSignalId, Number(sig.id || 0));
      await handleDmCallSignal(sig);
    }
  }catch(_){ }
}

function endDmCall(sendSignal=true){
  const callId = dmCallState?.callId;
  if(callId) rememberHandledDmCall(callId);
  if(sendSignal && callId) dmSendCallSignal("hangup", {}, callId).catch(()=>{});
  stopDmCallSignalPolling();
  try{ dmCallState?.pc?.close(); }catch(_){ }
  try{ dmCallState?.stream?.getTracks()?.forEach(t=>t.stop()); }catch(_){ }
  const local = $("dmLocalVideo");
  const remote = $("dmRemoteVideo");
  if(local) local.srcObject = null;
  if(remote) remote.srcObject = null;
  dmCallState = null;
  hideDmCallOverlay();
}


btnDmSend.onclick = async ()=>{
  try{
    if(!currentConversationId) return setMsg(dmMsg,t("selectChatFirst"));
    setMsg(dmMsg,"");
    const body = dmInput.value.trim();
    const file = dmPhoto.files && dmPhoto.files[0] ? dmPhoto.files[0] : null;
    const audioBlob = dmPendingVoiceBlob;
    if(!body && !file && !audioBlob) return setMsg(dmMsg, "Mesaj, dosya veya sesli mesaj gerekli.");
    const action = currentDmIsGroup() ? "dm_group_send" : "dm_send";
    const idField = currentDmIsGroup() ? "group_id" : "conversation_id";
    const idValue = String(currentConversationId);
    if(file || audioBlob){
      const fd = new FormData();
      fd.append(idField, idValue);
      fd.append("body", body);
      if(dmReplyTo) fd.append("reply_to_id", String(dmReplyTo.id));
      if(file) fd.append("photo", file);
      if(audioBlob) fd.append("audio", audioBlob, `voice-${Date.now()}.webm`);
      await api(action, "POST", fd, true);
    }else{
      await api(action, "POST", currentDmIsGroup()
        ? {group_id: currentConversationId, body, reply_to_id: dmReplyTo ? dmReplyTo.id : null}
        : {conversation_id: currentConversationId, body, reply_to_id: dmReplyTo ? dmReplyTo.id : null}
      );
    }
    dmInput.value="";
    if(dmPhoto) dmPhoto.value = "";
    syncDmAttachmentUi();
    clearPendingDmVoice();
    clearDmReply();
    await loadDmMessages(true);
    await refreshDmMeta();
    try{
      const list = await api("dm_list");
      renderDmList(list.items || []);
      if(currentConversationId) setActiveDmThread(String(currentConversationId), currentDmThreadKind);
    }catch(_){ }
    if(currentDmIsGroup()) api("dm_group_typing_set","POST",{group_id: currentConversationId, is_typing:0}).catch(()=>{});
    else api("dm_typing_set","POST",{conversation_id: currentConversationId, is_typing:0}).catch(()=>{});
    refreshProfileBadges();
    setMsg(dmMsg, audioBlob ? "✅ Sesli mesaj gönderildi." : "");
  }catch(e){ setMsg(dmMsg,e.message); }
};



if(dmPhoto){
  dmPhoto.addEventListener("change", ()=>syncDmAttachmentUi());
  syncDmAttachmentUi();
}
if(btnDmVoiceDiscard) btnDmVoiceDiscard.onclick = ()=>{ clearPendingDmVoice(); setMsg(dmMsg, "Sesli mesaj kaldırıldı."); };
if(dmInput){
  dmInput.addEventListener("keydown", (e)=>{
    if(e.key === "Enter" && !e.shiftKey){
      e.preventDefault();
      btnDmSend?.click();
    }
  });
}
setDmRecordHint();

function setDmReply(msg){
  dmReplyTo = msg;
  if(!msg){ clearDmReply(); return; }
  const who = (me && msg.sender_id===me.id) ? "Sen" : (msg.sender_name || "Biri");
  const body = msg.deleted_at ? "[silindi]" : (msg.body ? msg.body : (msg.audio_url ? "[sesli mesaj]" : (msg.photo_url ? "[foto]" : "")));
  dmReplyBar.innerHTML = `
    <div class="replyText">
      <div class="replyTitle">Yanıt: <b>${escapeHtml(who)}</b></div>
      <div class="replyBody">${escapeHtml(body)}</div>
    </div>
    <button class="btn" id="btnDmCancelReply">Kapat</button>
  `;
  dmReplyBar.classList.remove("hidden");
  const __btnDmCancelReply = $("btnDmCancelReply"); if(__btnDmCancelReply) __btnDmCancelReply.onclick = clearDmReply;
}

function clearDmReply(){
  dmReplyTo = null;
  dmReplyBar.classList.add("hidden");
  dmReplyBar.innerHTML = "";
}

// DM chat actions (reply/edit/delete)
dmChat.addEventListener("click", async (e)=>{
  const reactionEl = e.target.closest('[data-emoji], .emoji');
  if(reactionEl){
    e.preventDefault();
    e.stopPropagation();
    try{ reactionEl.remove(); }catch(_){ }
    return;
  }
  const actEl = e.target.closest("[data-act]");
  if(!actEl) return;
  const act = actEl.dataset.act;
  const mid = parseInt(actEl.dataset.id || "0");
  if(!mid) return;

  const current = dmAllItems.find(x=>x.id===mid);
  if(act==="reply" && current){
    setDmReply(current);
    dmInput.focus();
    return;
  }
  if(act==="edit"){
    if(!current || current.deleted_at) return;
    const nextBody = window.prompt("Mesajı düzenle", current.body || "");
    if(nextBody === null) return;
    await api(currentDmIsGroup() ? "dm_group_edit" : "dm_edit","POST",{message_id: mid, body: nextBody});
    await loadDmMessages(true);
    await refreshDmMeta();
    return;
  }
  if(act==="delete"){
    await api(currentDmIsGroup() ? "dm_group_delete" : "dm_delete","POST",{message_id: mid});
    await loadDmMessages(true);
    await refreshDmMeta();
    return;
  }
});

// Typing indicator (send small pings while user types)


// Typing indicator (send small pings while user types)
dmInput.addEventListener("input", ()=>{
  if(!currentConversationId) return;
  if(dmTypingPingTimer) return;
  if(currentDmIsGroup()) api("dm_group_typing_set","POST",{group_id: currentConversationId, is_typing:1}).catch(()=>{});
  else api("dm_typing_set","POST",{conversation_id: currentConversationId, is_typing:1}).catch(()=>{});
  dmTypingPingTimer = setTimeout(()=>{ dmTypingPingTimer=null; }, 1500);
  if(dmTypingTimer) clearTimeout(dmTypingTimer);
  dmTypingTimer = setTimeout(()=>{
    if(currentDmIsGroup()) api("dm_group_typing_set","POST",{group_id: currentConversationId, is_typing:0}).catch(()=>{});
    else api("dm_typing_set","POST",{conversation_id: currentConversationId, is_typing:0}).catch(()=>{});
  }, 2500);
});



if(btnDmMute) btnDmMute.onclick = async ()=>{
  try{
    if(!currentConversationId || currentDmIsGroup()) return setMsg(dmMsg, 'Önce bire bir sohbet seç.');
    const next = dmCurrentMuted() ? 0 : 1;
    const d = await api('dm_mute_set','POST',{conversation_id: currentConversationId, is_muted: next});
    currentDmThreadMeta = Object.assign({}, currentDmThreadMeta || {}, {is_muted: Number(d.is_muted || 0)});
    updateDmMuteButton();
    setMsg(dmMsg, Number(d.is_muted || 0) === 1 ? '🔕 Bu sohbet sessize alındı.' : '🔔 Bu sohbetin sesi açıldı.');
    const list = await api('dm_list');
    renderDmList(list.items || []);
    setActiveDmThread(String(currentConversationId), currentDmThreadKind);
  }catch(e){ setMsg(dmMsg, e.message || 'Sessize alma ayarı değiştirilemedi.'); }
};

if(btnDmVoiceRecord) btnDmVoiceRecord.onclick = ()=>toggleDmVoiceRecord();
if(btnDmAudioCall) btnDmAudioCall.onclick = ()=>startDmCall("audio");
if(btnDmVideoCall) btnDmVideoCall.onclick = ()=>startDmCall("video");

// Search in DM
dmSearch.addEventListener("input", ()=>{
  if(dmSearchTimer) clearTimeout(dmSearchTimer);
  dmSearchTimer = setTimeout(()=>{
    applyDmSearch();
  }, 150);
});

btnDmClearSearch.onclick = ()=>{
  dmSearch.value = "";
  applyDmSearch();
};

// ---- Psikoloğum ----

async function loadAdmin(){
  const me2 = await api("me");
  if(!me2.user || !me2.user.is_admin){
    throw new Error("Yetkisiz");
  }
  await loadAdminLogs();
  await loadAdminReports();
}

async function loadAdminLogs(){
  const d = await api("admin_badword_logs");
  adminLogsList.innerHTML = (d.logs||[]).map(x=>`
    <div class="fw">
      <div class="fwHead">
        <span>👤 ${escapeHtml(x.full_name)} • ${escapeHtml(x.context)}</span>
        <span class="muted small">${escapeHtml(x.created_at||"")}</span>
      </div>
      <div class="muted small" style="margin-top:6px">Orijinal:</div>
      <div style="white-space:pre-wrap">${escapeHtml(x.original_text||"")}</div>
      <div class="muted small" style="margin-top:6px">Sansürlü:</div>
      <div style="white-space:pre-wrap">${escapeHtml(x.censored_text||"")}</div>
    </div>
  `).join("") || `<p class="muted">Kayıt yok.</p>`;
}

async function loadAdminReports(){
  const st = adminReportStatus.value || "open";
  const d = await api("admin_reports","GET",{status: st});
  adminReportsList.innerHTML = (d.reports||[]).map(r=>`
    <div class="fw">
      <div class="fwHead">
        <span>🚩 #${r.id} • ${escapeHtml(r.target_type)}:${r.target_id}</span>
        <span class="muted small">${escapeHtml(r.created_at||"")}</span>
      </div>
      <div class="muted small">Raporlayan: ${escapeHtml(r.reporter_name||"")}</div>
      <div style="white-space:pre-wrap;margin-top:6px">${escapeHtml(r.reason||"")}</div>
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px">
        <button class="btn" data-act="adminDel" data-type="${escapeHtml(r.target_type)}" data-id="${r.target_id}">Admin Sil</button>
        <button class="btn" data-act="adminClose" data-rid="${r.id}">Kapat</button>
      </div>
    </div>
  `).join("") || `<p class="muted">Rapor yok.</p>`;
  // bind
  adminReportsList.querySelectorAll("[data-act='adminDel']").forEach(b=>{
    b.onclick = async ()=>{
      const type=b.dataset.type; const id=Number(b.dataset.id||0);
      await api("admin_delete","POST",{target_type:type,target_id:id});
      await loadAdminReports();
    };
  });
  adminReportsList.querySelectorAll("[data-act='adminClose']").forEach(b=>{
    b.onclick = async ()=>{
      const rid=Number(b.dataset.rid||0);
      await api("admin_report_close","POST",{id:rid});
      await loadAdminReports();
    };
  });
}

async function loadPsy(){
  const d = await api("psy_history");
  const items = (d.messages||[]).map((m, i)=>({
    id:i+1,
    role:m.role,
    content:m.content,
    created_at:m.created_at
  }));
  psyChat.dataset.items = JSON.stringify(items);
  renderChat(psyChat, items, null);
  psyLoaded = true;
}

btnPsySend.onclick = async ()=>{
  try{
    setMsg(psyMsg,"");
    const t = psyInput.value.trim();
    if(!t) return;
    // optimistic append
    const existing = psyChat.dataset.items ? JSON.parse(psyChat.dataset.items) : [];
    existing.push({role:"user",content:t,created_at:new Date().toLocaleString()});
    psyChat.dataset.items = JSON.stringify(existing);
    renderChat(psyChat, existing, null);

    const r = await api("psy_send","POST",{text:t});
    existing.push({role:"assistant",content:r.reply,created_at:new Date().toLocaleString()});
    psyChat.dataset.items = JSON.stringify(existing);
    renderChat(psyChat, existing, null);

    psyInput.value="";
  }catch(e){ setMsg(psyMsg,e.message); }
};

async function boot(){
  fillYearFilter();
  applyLanguage();
  bindAuthEnhancements();
  initAboutExperience();
  setMeetCategory(activeMeetCategory);
  // auto login with token
  try{
    const d = await api("me");
    setMe(d.user);
    activateUserSession(d.user);
    if(d.user){
      if(Number(d.user?.is_admin) === 1 && new URLSearchParams(location.search).get('fromAdmin') !== '1'){ window.location.href = 'admin.html'; return; }
      await refreshStats();
      await loadUsers();
      switchView("dashboard");
      await loadDashboard();
      maybeShowFirstWelcome(d.user);
      await loadAppNotifications();
      await checkReportReminders();
    }else{
      showAuth();
    }
  }catch(_){
    showAuth();
  }
}
boot();
let onlinePingTimer = null;
function startOnlinePing(){
  stopOnlinePing();
  onlinePingTimer = setInterval(()=>{
    if(getToken()) api("online_ping").catch(()=>{});
  }, 20000);
}
function stopOnlinePing(){
  if(onlinePingTimer){ clearInterval(onlinePingTimer); onlinePingTimer=null; }
}
async function loadOnlineList(){
  const d = await api("online_list");
  panelLegacyOnline.innerHTML = (d.users||[]).map(u=>`<div class="userRow">${avatarHtml(u)}<div><div style="font-weight:800">${escapeHtml(u.full_name)}</div><div class="muted small">${escapeHtml(u.school||"—")} • ${u.grad_year||"—"}</div></div></div>`).join("") || `<p class="muted">Kimse online görünmüyor.</p>`;
}

function showLegacyPanel(name){
  [panelLegacyChat,panelLegacyPolls,panelLegacyGossip,panelLegacyOnline].forEach(p=>p && p.classList.add("hidden"));
  [tabLegacyChat,tabLegacyPolls,tabLegacyGossip,tabLegacyOnline].forEach(t=>t && t.classList.remove("active"));
  if(name==="chat"){ panelLegacyChat.classList.remove("hidden"); tabLegacyChat.classList.add("active"); }
  if(name==="polls"){ panelLegacyPolls.classList.remove("hidden"); tabLegacyPolls.classList.add("active"); }
  if(name==="gossip"){ panelLegacyGossip.classList.remove("hidden"); tabLegacyGossip.classList.add("active"); }
  if(name==="online"){ panelLegacyOnline.classList.remove("hidden"); tabLegacyOnline.classList.add("active"); }
}
async function loadPolls(){ const polls = await api('poll_list'); renderPolls(polls.polls || []); }
async function loadGossipTrending(){ return; }

if(tabLegacyChat) tabLegacyChat.onclick = async ()=>{ showLegacyPanel("chat"); await loadLegacy(); };
if(tabLegacyPolls) tabLegacyPolls.onclick = async ()=>{ showLegacyPanel("polls"); await loadPolls(); };
if(tabLegacyGossip) tabLegacyGossip.onclick = async ()=>{ showLegacyPanel("gossip"); await loadGossip(); await loadGossipTrending(); };
if(tabLegacyOnline) tabLegacyOnline.onclick = async ()=>{ showLegacyPanel("online"); await loadOnlineList(); };

if(btnClosePhotoModal) btnClosePhotoModal.onclick = ()=>closePhotoModal();
if(photoModal) photoModal.onclick = (e)=>{ if(e.target===photoModal) closePhotoModal(); };
document.addEventListener("keydown", (e)=>{ if(e.key==="Escape") closePhotoModal(); });


// ---- MEra Nova / Premium features ----
let activeNovaTab = 'capsule';
let activeRoomId = 0;
let cachedRooms = [];
let cachedYearbook = null;
let lastDmGroupExtrasKey = '';

function setNovaTab(tab){
  activeNovaTab = tab;
  document.querySelectorAll('#novaTabs [data-novatab]').forEach(btn=>btn.classList.toggle('active', btn.dataset.novatab===tab));
  document.querySelectorAll('[data-novapanel]').forEach(panel=>panel.classList.toggle('hidden', panel.dataset.novapanel!==tab));
}

async function loadNovaCurrentTab(){
  if(activeNovaTab === 'capsule') return loadCapsules();
  if(activeNovaTab === 'map') return loadNovaMap();
  if(activeNovaTab === 'rooms') return loadNovaRooms();
  if(activeNovaTab === 'wall') return loadMemoryWall();
  if(activeNovaTab === 'yearbook') return loadYearbook();
}

function stageLabel(stage){
  const trMap = {university:'Üniversiteye geçti', internship:'Staj arıyor', work:'İşte', circle:'Aynı çevrede'};
  const enMap = {university:'Moved to university', internship:'Looking for internship', work:'Working', circle:'Still around the same circle'};
  const map = lang === 'en' ? enMap : trMap;
  return map[stage] || t('stageUnspecified');
}

function activeAreaText(key){
  const map = { photos:'activeAreaPhotos', farewells:'activeAreaFarewells', orbit:'activeAreaOrbit', memories:'activeAreaMemories', notes:'activeAreaNotes' };
  return map[key] ? t(map[key]) : t('activeAreaQuiet');
}
function orbitModeText(mode){ return mode === 'guest' ? t('orbitAsGuest') : t('orbitAsHost'); }
function trustTone(score){ if(score >= 80) return t('trustStrong'); if(score >= 45) return t('trustGrowing'); return t('trustNew'); }
function renderMeetHistory(items){
  const box = $('meetHistoryBox');
  if(!box) return;
  const rows = Array.isArray(items) ? items : [];
  box.innerHTML = rows.length ? rows.map(item=>`<div class="novaItem">${avatarHtml({full_name:item.host_name, photo_url:item.host_photo})}<div style="flex:1"><b>${escapeHtml(item.title || '')}</b><div class="muted small">${escapeHtml(item.host_name || '')} • ${escapeHtml(item.category === 'pitch' ? t('meetPitch') : t('meetCoffee'))}</div><div class="muted small">${escapeHtml(item.meeting_at || '')}</div></div><span class="miniBadge">${t('meetHistoryJoined')}</span></div>`).join('') : `<div class="meetPanelEmpty">${t('meetNoHistory')}</div>`;
}

function relTimeLabel(dtStr){
  const dt = new Date(String(dtStr||'').replace(' ', 'T'));
  if(Number.isNaN(dt.getTime())) return dtStr || '—';
  const diff = Math.max(0, Date.now() - dt.getTime());
  const mins = Math.round(diff/60000);
  if(mins < 60) return lang === 'en' ? `${mins||1} min ago` : `${mins||1} dk önce`;
  const hrs = Math.round(mins/60);
  if(hrs < 24) return lang === 'en' ? `${hrs} hr ago` : `${hrs} saat önce`;
  const days = Math.round(hrs/24);
  return lang === 'en' ? `${days} day ago` + (days>1?'s':'') : `${days} gün önce`;
}

async function loadCapsules(){
  const list = $('capsuleList'); if(!list) return;
  list.innerHTML = `<div class="skeletonCard"></div><div class="skeletonCard"></div>`;
  const d = await api('time_capsules_list');
  const items = d.items || [];
  list.innerHTML = items.map(it=>`<div class="novaItem cardHoverLift"><div class="novaItemHead"><b>${escapeHtml(it.title)}</b><span class="badge ${it.can_open?'ok':''}">${it.can_open?t('capsuleReady'):t('capsuleLocked')}</span></div><div class="muted small">${escapeHtml(it.open_at || '')}</div><div style="margin-top:8px">${escapeHtml(it.preview || '')}</div>${it.can_open ? `<div class="profileInlineActions"><button class="btn" data-open-capsule="${it.id}">${t('capsuleOpen')}</button></div>`:''}</div>`).join('') || `<p class="muted">${t('capsuleEmpty')}</p>`;
  list.querySelectorAll('[data-open-capsule]').forEach(btn=>btn.onclick = async ()=>{
    const d2 = await api('time_capsule_open','GET',{id:Number(btn.dataset.openCapsule)});
    alert(`${d2.item.title}\n\n${d2.item.body}`);
  });
}

async function loadNovaMap(){
  const params = { school:$('mapSchool')?.value?.trim()||'', grad_year:$('mapGrad')?.value?.trim()||'', city:$('mapCity')?.value?.trim()||'', stage:$('mapStage')?.value||'' };
  const d = await api('nova_map','GET',params);
  const sum = d.summary || {};
  const summary = $('mapSummary');
  const list = $('mapList');
  if(summary) summary.innerHTML = `<span class="novaStat">👥 ${sum.total||0} kişi</span><span class="novaStat">🏙️ ${sum.cities||0} şehir</span><span class="novaStat">🎓 ${sum.university||0}</span><span class="novaStat">💼 ${sum.work||0}</span><span class="novaStat">🧩 ${sum.internship||0}</span>`;
  if(list) list.innerHTML = (d.items||[]).map(u=>`<div class="novaItem mapNode cardHoverLift" data-openprofile="${u.id}">${avatarHtml(u)}<div style="flex:1"><div><b>${escapeHtml(u.full_name)}</b></div><div class="muted small">${escapeHtml(u.school||'—')} • ${u.grad_year||'—'} • ${escapeHtml(u.city||(lang==='en'?'No city':'Şehir yok'))}</div><div class="small">${escapeHtml(stageLabel(u.current_stage))}</div></div><span class="miniBadge">${u.follower_count||0}</span></div>`).join('') || `<p class="muted">${t('roomNoMatch')}</p>`;
  list?.querySelectorAll('[data-openprofile]').forEach(btn=>btn.onclick = ()=>selectUser(Number(btn.dataset.openprofile)));
}

async function loadNovaRooms(roomId=activeRoomId){
  const d = await api('nova_rooms_list','GET',{room_id: roomId || 0});
  cachedRooms = d.rooms || [];
  activeRoomId = Number(d.active_room_id || (cachedRooms[0]?.id || 0));
  const roomList = $('roomList');
  if(roomList) roomList.innerHTML = cachedRooms.map(room=>`<button type="button" class="roomCard ${Number(room.id)===Number(activeRoomId)?'active':''}" data-room="${room.id}"><div><b>${escapeHtml(room.title)}</b><div class="muted small">${escapeHtml(room.description||'')}</div></div><span class="miniBadge ${room.joined?'glowDot':''}">${room.member_count||0}</span></button>`).join('');
  roomList?.querySelectorAll('[data-room]').forEach(btn=>btn.onclick = ()=>loadNovaRooms(Number(btn.dataset.room)));
  const active = cachedRooms.find(r=>Number(r.id)===Number(activeRoomId));
  const meta = $('roomMeta');
  if(meta && active) meta.innerHTML = `${escapeHtml(active.title)} • ${active.member_count||0} üye ${active.auto_city && active.city ? `• ${escapeHtml(active.city)}` : ''}`;
  const feed = $('roomFeed');
  if(feed) feed.innerHTML = (d.posts||[]).map(post=>`<div class="novaItem"><div class="novaItemHead">${avatarHtml(post.user||{})}<div><b>${escapeHtml(post.user?.full_name||'')}</b><div class="muted small">${escapeHtml(relTimeLabel(post.created_at))}</div></div></div><div style="margin-top:8px">${escapeHtml(post.body||'')}</div></div>`).join('') || `<p class="muted">${t('roomEmpty')}</p>`;
}

async function loadMemoryWall(){
  const list = $('wallList'); if(!list) return;
  list.innerHTML = `<div class="skeletonCard"></div><div class="skeletonCard"></div>`;
  const d = await api('memory_wall_list');
  list.innerHTML = (d.items||[]).map(post=>`<div class="novaItem memoryCard cardHoverLift"><div class="novaItemHead">${avatarHtml(post.user||{})}<div><b>${escapeHtml(post.title)}</b><div class="muted small">${escapeHtml(post.user?.full_name||'')} • ${escapeHtml(relTimeLabel(post.created_at))}</div></div><span class="badge">${escapeHtml(post.category||'anı')}</span></div>${post.image_url?`<img class="memoryPhoto" src="${escapeHtml(resolveUrl(post.image_url))}"/>`:''}<div style="margin-top:10px">${escapeHtml(post.body||'')}</div><div class="profileInlineActions"><button class="btn ${post.reacted_me?'primary':''}" data-remember="${post.id}">✨ Hatırla (${post.remember_count||0})</button></div></div>`).join('') || `<p class="muted">Henüz anı yok.</p>`;
  list.querySelectorAll('[data-remember]').forEach(btn=>btn.onclick = async ()=>{ await api('memory_wall_react','POST',{post_id:Number(btn.dataset.remember)}); await loadMemoryWall(); });
}

function renderYearbookSummary(data){
  const summary = $('yearbookSummary');
  const list = $('yearbookList');
  const cityList = $('cityPresenceList');
  const s = data.summary || {};
  if(summary) summary.innerHTML = `
    <span class="novaStat">👥 ${s.students||0} ${lang==='en'?'people':'kişi'}</span>
    ${s.classmates ? `<span class="novaStat">🏷️ ${s.classmates} ${lang==='en'?'same class':'aynı sınıf'}</span>` : ''}
    ${s.top_talker ? `<span class="novaStat">💬 ${escapeHtml(s.top_talker.full_name)} (${Number(s.top_talker.count||0)})</span>` : ''}
    ${s.top_farewell ? `<span class="novaStat">💌 ${escapeHtml(s.top_farewell.full_name)} (${Number(s.top_farewell.count||0)})</span>` : ''}
    ${s.top_photos ? `<span class="novaStat">🖼️ ${escapeHtml(s.top_photos.full_name)} (${Number(s.top_photos.count||0)})</span>` : ''}`;

  const classmates = Array.isArray(data.classmates) ? data.classmates : [];
  const schoolmates = Array.isArray(data.schoolmates) ? data.schoolmates : [];
  const matches = Array.isArray(data.matches) ? data.matches : [];
  const playlist = Array.isArray(data.playlist) ? data.playlist : [];
  const quotes = Array.isArray(data.quotes) ? data.quotes : [];
  if(list) list.innerHTML = `
    <div class="novaSubTitle">${t('yearbookAwards')}</div>
    <div class="novaAwardsGrid">
      <div class="novaAwardCard"><span class="muted small">${t('yearbookTopTalker')}</span><b>${escapeHtml(s.top_talker ? `${s.top_talker.full_name} (${s.top_talker.count})` : '—')}</b></div>
      <div class="novaAwardCard"><span class="muted small">${t('yearbookTopFarewell')}</span><b>${escapeHtml(s.top_farewell ? `${s.top_farewell.full_name} (${s.top_farewell.count})` : '—')}</b></div>
      <div class="novaAwardCard"><span class="muted small">${t('yearbookTopPhotos')}</span><b>${escapeHtml(s.top_photos ? `${s.top_photos.full_name} (${s.top_photos.count})` : '—')}</b></div>
      <div class="novaAwardCard"><span class="muted small">${t('yearbookThemeSong')}</span><b>${escapeHtml(s.theme_song ? `${s.theme_song.user_name} • ${s.theme_song.platform}` : '—')}</b></div>
    </div>
    <div class="novaSubTitle">${t('yearbookSameClass')}</div>
    ${classmates.map(u=>`<div class="novaItem" data-openprofile="${u.id}">${avatarHtml(u)}<div style="flex:1"><b>${escapeHtml(u.full_name)}</b><div class="muted small">${escapeHtml(u.school||'—')} • ${u.grad_year||'—'} ${u.class_label?`• ${escapeHtml(u.class_label)}`:''} ${u.city?`• ${escapeHtml(u.city)}`:''}</div><div class="novaRelation">${t('sameClass')}</div></div><span class="miniBadge">${escapeHtml(u.class_label || t('classBadgeDefault'))}</span></div>`).join('') || `<p class="muted">${t('noOneYet')}</p>`}
    <div class="novaSubTitle">${t('yearbookSameSchool')}</div>
    ${schoolmates.map(u=>`<div class="novaItem" data-openprofile="${u.id}">${avatarHtml(u)}<div style="flex:1"><b>${escapeHtml(u.full_name)}</b><div class="muted small">${escapeHtml(u.school||'—')} • ${u.grad_year||'—'} ${u.class_label?`• ${escapeHtml(u.class_label)}`:''} ${u.city?`• ${escapeHtml(u.city)}`:''}</div><div class="novaRelation">${t('sameSchool')}</div></div><span class="miniBadge">${t('schoolBadgeDefault')}</span></div>`).join('') || `<p class="muted">${t('noOneYet')}</p>`}
    <div class="novaSubTitle">${t('yearbookMatches')}</div>
    ${matches.map(u=>`<div class="novaItem" data-openprofile="${u.id}">${avatarHtml(u)}<div style="flex:1"><b>${escapeHtml(u.full_name)}</b><div class="muted small">${u.match_count||0} ${lang==='en'?'shared memory categories':'ortak anı kategorisi'}</div></div><span class="miniBadge">${u.match_count||0}</span></div>`).join('') || `<p class="muted">${t('noMatchYet')}</p>`}
    <div class="novaSubTitle">${t('yearbookPlaylistTitle')}</div>
    ${playlist.map(row=>`<div class="novaItem"><div style="flex:1"><b>${escapeHtml(row.user_name||'')}</b><div class="muted small">${escapeHtml(row.platform||'')}</div><a href="${escapeHtml(row.track_url||'#')}" target="_blank" rel="noreferrer">${escapeHtml(row.track_url||'')}</a><div class="small">${escapeHtml(row.note_body||'')}</div></div></div>`).join('') || `<p class="muted">${t('noSongsYet')}</p>`}
    <div class="novaSubTitle">${t('yearbookQuotesList')}</div>
    ${quotes.map(row=>`<div class="novaItem"><div style="flex:1"><b>${t(row.quote_type === 'teacher' ? 'quoteTypeTeacher' : 'quoteTypePeriod')}</b><div>${escapeHtml(row.quote_body || '')}</div><div class="muted small">${escapeHtml(row.user_name || '')}</div></div></div>`).join('') || `<p class="muted">${t('noQuotesYet')}</p>`}`;
  list?.querySelectorAll('[data-openprofile]').forEach(btn=>btn.onclick = ()=>selectUser(Number(btn.dataset.openprofile)));
  if(cityList) cityList.innerHTML = (data.presence||[]).map(x=>`<div class="novaItem"><b>${escapeHtml(x.city||'')}</b><span class="miniBadge">${x.count||0}</span></div>`).join('') || `<p class="muted">${t('noCitiesYet')}</p>`;
}

async function loadYearbook(){
  const school = $('yearbookSchool')?.value?.trim() || me?.school || '';
  const grad = $('yearbookGrad')?.value?.trim() || me?.grad_year || '';
  if($('yearbookSchool') && !$('yearbookSchool').value) $('yearbookSchool').value = school || '';
  if($('yearbookGrad') && !$('yearbookGrad').value && grad) $('yearbookGrad').value = String(grad);
  if(!school || !grad) return;
  const d = await api('yearbook_summary','GET',{school,grad_year:grad});
  cachedYearbook = {school, grad_year:grad};
  renderYearbookSummary(d);
}


async function loadProfileNotes(userId, mode='received'){
  const d = await api('profile_notes_list','GET',{to_user_id:userId, mode});
  return d.items || [];
}

async function enhanceProfilePremium(user){
  if(!user) return;
  const hero = $('profileHeader');
  if(hero && !hero.querySelector('.anniversaryChip') && user.grad_year){
    const chip = document.createElement('div');
    chip.className = 'anniversaryChip';
    chip.textContent = `🎓 ${user.grad_year} ${lang==='en' ? 'era' : 'dönemi'}`;
    hero.querySelector('.profileHeroIdentity')?.appendChild(chip);
  }
  const editBio = $('editBio');
  if(editBio && !$('editCity')){
    const grid = editBio.closest('.profileFormGrid');
    const wrap = document.createElement('div');
    wrap.className = 'profileField';
    wrap.innerHTML = `<label class="small muted">${t('cityLabel')}</label><input class="input" id="editCity" placeholder="${lang==='en'?'Istanbul':'İstanbul'}"/>`;
    const wrap2 = document.createElement('div');
    wrap2.className = 'profileField';
    wrap2.innerHTML = `<label class="small muted">${t('stageLabel')}</label><select class="input" id="editStage"><option value="">${t('stageUnspecified')}</option><option value="university">${stageLabel('university')}</option><option value="internship">${stageLabel('internship')}</option><option value="work">${stageLabel('work')}</option><option value="circle">${stageLabel('circle')}</option></select>`;
    grid?.appendChild(wrap); grid?.appendChild(wrap2);
    $('editCity').value = user.city || '';
    $('editStage').value = user.current_stage || '';
  }
  const infoGrid = document.querySelector('.profileInfoGrid');
  if(infoGrid && !document.querySelector('.profileInfoItem.cityCard')){
    const cityCard = document.createElement('div');
    cityCard.className = 'profileInfoItem cityCard';
    cityCard.innerHTML = `<span class="muted small">${t('cityLabel')}</span><b>${escapeHtml(user.city || '—')}</b>`;
    const stCard = document.createElement('div');
    stCard.className = 'profileInfoItem cityCard';
    stCard.innerHTML = `<span class="muted small">${t('stageLabel')}</span><b>${escapeHtml(stageLabel(user.current_stage))}</b>`;
    const classCard = document.createElement('div');
    classCard.className = 'profileInfoItem cityCard';
    classCard.innerHTML = `<span class="muted small">${t('classLabel')}</span><b>${escapeHtml(user.class_label || '—')}</b>`;
    infoGrid.appendChild(cityCard); infoGrid.appendChild(stCard); infoGrid.appendChild(classCard);
  }

  let pulseWrap = $('profilePulseWrap');
  if(!pulseWrap && panelProfile){
    pulseWrap = document.createElement('div');
    pulseWrap.id = 'profilePulseWrap';
    pulseWrap.className = 'profileSection profileCompactCard profilePulseCard';
    panelProfile.prepend(pulseWrap);
  }
  if(pulseWrap){
    try{
      const d = await api('profile_premium_summary','GET',{user_id:user.id});
      const s = d.summary || {};
      pulseWrap.innerHTML = `
        <div class="profileSectionTitle">${t('profilePulseTitle')}</div>
        <div class="profilePulseGrid">
          <div class="pulseMetric"><span>${t('profileActiveArea')}</span><b>${escapeHtml(activeAreaText(s.active_area))}</b><small>${Number(s.active_area_count||0)}</small></div>
          <div class="pulseMetric"><span>${t('profileLastSong')}</span><b>${escapeHtml(s.last_track ? (s.last_track.platform || 'Spotify') : t('noTrackYet'))}</b><small>${escapeHtml(s.last_track?.track_url || '')}</small></div>
          <div class="pulseMetric"><span>${t('profileLastOrbit')}</span><b>${escapeHtml(s.last_orbit ? s.last_orbit.title : t('noOrbitYet'))}</b><small>${escapeHtml(s.last_orbit ? orbitModeText(s.last_orbit.mode) : '')}</small></div>
          <div class="pulseMetric"><span>${t('profileLastRating')}</span><b>${s.last_rating ? '⭐ '.concat(String(s.last_rating.rating)) : t('noRatingYet')}</b><small>${escapeHtml(s.last_rating?.comment || '')}</small></div>
          <div class="pulseMetric"><span>${t('profilePrivateNoteCount')}</span><b>${Number(s.note_count||0)}</b><small>${t('privateNotesTitle')}</small></div>
        </div>
        <div class="profileSectionTitle" style="margin-top:16px">${t('profileAchievements')}</div>
        <div class="profileAchievementRow">${(s.achievements||[]).map(a=>`<span class="profileAchievementChip">✨ ${escapeHtml(a.label||'')}</span>`).join('') || `<span class="muted">${t('noAchievementsYet')}</span>`}</div>`;
    }catch(_){ }
  }

  let noteWrap = $('profileNotesWrap');
  if(!noteWrap && panelProfile){
    noteWrap = document.createElement('div');
    noteWrap.id = 'profileNotesWrap';
    noteWrap.className = 'profileSection profileCompactCard';
    panelProfile.appendChild(noteWrap);
  }
  if(noteWrap){
    if(me && Number(me.id)===Number(user.id)){
      const notes = await loadProfileNotes(user.id,'received');
      noteWrap.innerHTML = `<div class="profileSectionTitle">${t('privateNotesTitle')}</div>${notes.map(n=>`<div class="novaItem">${avatarHtml(n.user||{})}<div style="flex:1"><b>${escapeHtml(n.user?.full_name||'')}</b><div>${escapeHtml(n.note_body||'')}</div><div class="muted small">${escapeHtml(relTimeLabel(n.created_at))}</div></div></div>`).join('') || `<p class="muted">${t('noPrivateNotes')}</p>`}`;
    }else{
      noteWrap.innerHTML = `<div class="profileSectionTitle">${t('leavePrivateNote')}</div><textarea class="input" id="privateNoteBody" placeholder="${t('leavePrivateNotePh')}" style="min-height:88px"></textarea><div class="profileInlineActions"><button class="btn primary" id="btnSendPrivateNote">${t('privateNoteBtn')}</button><span class="muted" id="privateNoteMsg"></span></div>`;
      $('btnSendPrivateNote').onclick = async ()=>{ try{ await api('profile_note_add','POST',{to_user_id:user.id, note_body:$('privateNoteBody').value.trim()}); $('privateNoteBody').value=''; setMsg($('privateNoteMsg'),t('privateNoteSent')); }catch(e){ setMsg($('privateNoteMsg'), e.message); } };
    }
  }
}

async function loadDmGroupExtras(){
  const wrap = $('dmGroupExtras');
  if(!wrap) return;
  if(!currentDmIsGroup() || !currentConversationId){ wrap.classList.add('hidden'); wrap.innerHTML=''; return; }
  const key = `${currentConversationId}`;
  const d = await api('dm_group_extras','GET',{group_id:currentConversationId});
  const ex = d.extras || {};
  wrap.classList.remove('hidden');
  wrap.innerHTML = `
    <div class="dmGroupExtrasHead">
      <div class="dmExtrasTitle">${t('groupToolsTitle')}</div>
      <div class="profileInlineActions">
        <button class="btn" id="btnNewGroupPoll">${t('groupMiniPoll')}</button>
        <button class="btn" id="btnNewGroupEvent">${t('groupPlanEvent')}</button>
      </div>
    </div>
    <div class="dmExtrasGrid">
      <div class="dmExtraCard"><div class="profileSectionTitle">${t('groupAlbumTitle')}</div>${(ex.album||[]).length ? `<div class="dmAlbumGrid">${ex.album.map(a=>`<img src="${escapeHtml(resolveUrl(a.photo_url))}"/>`).join('')}</div>` : `<div class="muted small">${t('groupNoMedia')}</div>`}</div>
      <div class="dmExtraCard"><div class="profileSectionTitle">${t('groupPollsTitle')}</div>${(ex.polls||[]).map(p=>`<div class="novaItem"><b>${escapeHtml(p.question)}</b>${(p.options||[]).map(o=>`<button class="btn ${o.voted_me?'primary':''}" data-grouppollvote="${o.id}">${escapeHtml(o.text)} (${o.vote_count||0})</button>`).join('')}</div>`).join('') || `<div class="muted small">${t('groupNoPolls')}</div>`}</div>
      <div class="dmExtraCard"><div class="profileSectionTitle">${t('groupEventsTitle')}</div>${(ex.events||[]).map(ev=>`<div class="novaItem"><b>${escapeHtml(ev.title)}</b><div class="muted small">${escapeHtml(ev.event_at||'')} • ${escapeHtml(ev.location||t('groupNoLocation'))}</div><div>${escapeHtml(ev.note_body||'')}</div></div>`).join('') || `<div class="muted small">${t('groupNoEvents')}</div>`}</div>
      <div class="dmExtraCard"><div class="profileSectionTitle">${t('groupRolesTitle')}</div>${(ex.members||[]).map(m=>`<div class="novaItem">${m.photo_url?`<div class="avatar"><img src="${escapeHtml(resolveUrl(m.photo_url))}"></div>`:avatarHtml({full_name:m.full_name})}<div style="flex:1"><b>${escapeHtml(m.full_name||'')}</b><div class="muted small">${escapeHtml(m.role||'member')}</div></div>${ex.role==='owner' && Number(m.id)!==Number(me?.id||0) ? `<button class="btn" data-setrole="${m.id}" data-role="${m.role==='admin'?'member':'admin'}">${m.role==='admin'?t('groupMakeMember'):t('groupMakeAdmin')}</button>`:''}</div>`).join('') || `<div class="muted small">${t('groupNoMembers')}</div>`}</div>
    </div>`;
  $('btnNewGroupPoll')?.addEventListener('click', async ()=>{
    const q = prompt(t('groupPollQuestionPrompt')); if(!q) return; const raw = prompt(t('groupPollOptionsPrompt')); if(!raw) return;
    await api('dm_group_poll_create','POST',{group_id:currentConversationId, question:q.trim(), options:raw.split('|').map(x=>x.trim()).filter(Boolean)});
    await loadDmGroupExtras();
  });
  $('btnNewGroupEvent')?.addEventListener('click', async ()=>{
    const title = prompt(t('groupEventTitlePrompt')); if(!title) return; const when = prompt(t('groupEventDatePrompt')); if(!when) return; const location = prompt(t('groupEventLocationPrompt')) || ''; const note = prompt(t('groupEventNotePrompt')) || '';
    await api('dm_group_event_create','POST',{group_id:currentConversationId, title:title.trim(), event_at:when.trim(), location, note_body:note});
    await loadDmGroupExtras();
  });
  wrap.querySelectorAll('[data-grouppollvote]').forEach(btn=>btn.onclick = async ()=>{ await api('dm_group_poll_vote','POST',{group_id:currentConversationId, option_id:Number(btn.dataset.grouppollvote)}); await loadDmGroupExtras(); });
  wrap.querySelectorAll('[data-setrole]').forEach(btn=>btn.onclick = async ()=>{ await api('dm_group_set_role','POST',{group_id:currentConversationId, user_id:Number(btn.dataset.setrole), role:String(btn.dataset.role)}); await loadDmGroupExtras(); });
  if(lastDmGroupExtrasKey !== key){ lastDmGroupExtrasKey = key; }
}

function initNovaBindings(){
  document.querySelectorAll('#novaTabs [data-novatab]').forEach(btn=>btn.onclick = async ()=>{ setNovaTab(btn.dataset.novatab); await loadNovaCurrentTab(); });
  $('btnCreateCapsule')?.addEventListener('click', async ()=>{
    try{ await api('time_capsule_create','POST',{title:$('capsuleTitle').value.trim(), body:$('capsuleBody').value.trim(), open_at:$('capsuleOpenAt').value}); $('capsuleTitle').value=''; $('capsuleBody').value=''; $('capsuleOpenAt').value=''; setMsg($('capsuleMsg'),'✅ Kapsül kaydedildi.'); await loadCapsules(); }catch(e){ setMsg($('capsuleMsg'), e.message); }
  });
  $('btnLoadMap')?.addEventListener('click', ()=>loadNovaMap().catch(e=>setMsg($('mapMsg'), e.message)));
  $('btnSendRoomPost')?.addEventListener('click', async ()=>{ try{ await api('nova_room_post','POST',{room_id:activeRoomId, body:$('roomPostInput').value.trim()}); $('roomPostInput').value=''; await loadNovaRooms(activeRoomId); }catch(e){ setMsg($('roomMsg'), e.message); } });
  $('btnRoomCreateGroup')?.addEventListener('click', async ()=>{ try{ const d = await api('nova_room_create_group','POST',{room_id:activeRoomId}); const list = await api('dm_list'); renderDmList(list.items||[]); const thread = (list.items||[]).find(x=>(x.thread_kind||'direct')==='group' && Number(x.group_id||x.conversation_id||0)===Number(d.group_id)); switchView('dm'); if(thread) await openDmThreadItem(thread,'✅ Oda için grup kuruldu.'); }catch(e){ setMsg($('roomMsg'), e.message); } });
  $('btnCreateWallPost')?.addEventListener('click', async ()=>{ try{ const fd = new FormData(); fd.append('title',$('wallTitle').value.trim()); fd.append('category',$('wallCategory').value); fd.append('body',$('wallBody').value.trim()); const f=$('wallPhoto').files?.[0]; if(f) fd.append('photo',f); await api('memory_wall_create','POST',fd,true); $('wallTitle').value=''; $('wallBody').value=''; $('wallPhoto').value=''; setMsg($('wallMsg'),'✅ Anı paylaşıldı.'); await loadMemoryWall(); }catch(e){ setMsg($('wallMsg'), e.message); } });
  $('btnLoadYearbook')?.addEventListener('click', ()=>loadYearbook().catch(e=>setMsg($('yearbookMsg'), e.message)));
  $('btnAddPlaylist')?.addEventListener('click', async ()=>{ try{ const school = $('yearbookSchool').value.trim() || me?.school || ''; const grad = $('yearbookGrad').value.trim() || me?.grad_year || ''; await api('yearbook_playlist_add','POST',{school, grad_year:grad, platform:$('playlistPlatform').value, track_url:$('playlistUrl').value.trim(), note_body:$('playlistNote').value.trim()}); $('playlistUrl').value=''; $('playlistNote').value=''; setMsg($('playlistMsg'),t('sentSongOk')); await loadYearbook(); }catch(e){ setMsg($('playlistMsg'), e.message); } });
  $('btnAddYearbookQuote')?.addEventListener('click', async ()=>{ try{ const school=$('yearbookSchool').value.trim() || me?.school || ''; const grad=$('yearbookGrad').value.trim() || me?.grad_year || ''; await api('yearbook_quote_add','POST',{school,grad_year:grad, quote_type:$('yearbookQuoteType').value, quote_body:$('yearbookQuoteBody').value.trim()}); $('yearbookQuoteBody').value=''; setMsg($('yearbookQuoteMsg'),t('sentQuoteOk')); await loadYearbook(); }catch(e){ setMsg($('yearbookQuoteMsg'), e.message); } });
}

setTimeout(()=>{ try{ initNovaBindings(); }catch(_){ } }, 0);

// --- MEra Blast mini game ---
const BLAST_SIZE = 6;
const BLAST_BEST_KEY = 'mera_blast_best_score';
let blastState = { board: [], pieces: [], selected: -1, score: 0, combo: 0, rankScope: 'school', loaded: false, dragging: -1, ended: false, submitting: false, activeGame: 'blast' };
const BLAST_COLORS = ['aqua','sun','grape','lime','coral','sky'];
const BLAST_SHAPES = [
  [[1]], [[1,1]], [[1],[1]], [[1,1,1]], [[1],[1],[1]],
  [[1,1],[1,0]], [[1,1],[0,1]], [[1,1],[1,1]]
];
function blastEmptyBoard(){ return Array.from({length:BLAST_SIZE},()=>Array(BLAST_SIZE).fill(null)); }
function blastCloneShape(shape){ return shape.map(r=>r.slice()); }
function blastNewPieces(){ return Array.from({length:3},()=>({ shape: blastCloneShape(BLAST_SHAPES[Math.floor(Math.random()*BLAST_SHAPES.length)]), color: BLAST_COLORS[Math.floor(Math.random()*BLAST_COLORS.length)] })); }
function blastPieceShape(piece){ return Array.isArray(piece) ? piece : piece?.shape; }
function blastPieceColor(piece){ return Array.isArray(piece) ? 'grape' : (piece?.color || 'grape'); }
function blastCanPlace(piece, r, c){
  const shape = blastPieceShape(piece); if(!shape) return false;
  for(let y=0;y<shape.length;y++) for(let x=0;x<shape[y].length;x++) if(shape[y][x]){
    if(r+y>=BLAST_SIZE || c+x>=BLAST_SIZE || blastState.board[r+y][c+x]) return false;
  }
  return true;
}
function blastHasMove(){ return blastState.pieces.some(piece=>piece && blastState.board.some((_,r)=>blastState.board[r].some((__,c)=>blastCanPlace(piece,r,c)))); }
function blastClearHints(){ blastBoard?.querySelectorAll('.canDrop,.badDrop,.ghostDrop').forEach(el=>el.classList.remove('canDrop','badDrop','ghostDrop')); }
function blastPreview(pieceIndex, r, c){
  blastClearHints();
  const piece = blastState.pieces[pieceIndex]; const shape = blastPieceShape(piece); if(!shape) return;
  const ok = blastCanPlace(piece,r,c);
  for(let y=0;y<shape.length;y++) for(let x=0;x<shape[y].length;x++) if(shape[y][x]){
    const cell = blastBoard?.querySelector('[data-r="'+(r+y)+'"][data-c="'+(c+x)+'"]');
    if(cell) cell.classList.add(ok?'canDrop':'badDrop','ghostDrop');
  }
}
function arcadePanel(){ return blastState.activeGame === 'm2' ? document.querySelector('[data-game-panel="m2"]') : document.querySelector('[data-game-panel="blast"]'); }
function arcadeToast(text, kind=''){
  const panel = arcadePanel(); if(!panel) return;
  const old = panel.querySelector('.arcadeToast'); if(old) old.remove();
  const t = document.createElement('div'); t.className = 'arcadeToast '+kind; t.textContent = text; panel.appendChild(t);
  setTimeout(()=>t.remove(), 1400);
}
function arcadeFireworks(count=14){
  const panel = arcadePanel(); if(!panel) return;
  for(let i=0;i<count;i++){
    const c=document.createElement('span'); c.className='arcadeConfetti c'+(i%6);
    c.style.setProperty('--dx', (Math.cos(i/count*Math.PI*2)*(70+Math.random()*65))+'px');
    c.style.setProperty('--dy', (Math.sin(i/count*Math.PI*2)*(55+Math.random()*75)-20)+'px');
    c.style.left = (45 + Math.random()*12) + '%'; c.style.top = (115 + Math.random()*22) + 'px';
    panel.appendChild(c); setTimeout(()=>c.remove(), 1100);
  }
}
function arcadeBump(el){ if(!el) return; el.classList.remove('arcadeBump'); void el.offsetWidth; el.classList.add('arcadeBump'); }
function arcadeRestartMessage(msgEl, text, label, fnName){
  if(!msgEl) return;
  msgEl.innerHTML = '<span>'+escapeHtml(text)+'</span> <button type="button" class="btn primary arcadeRestartBtn" onclick="'+fnName+'()">'+escapeHtml(label)+'</button>';
}
function blastRender(){
  if(!blastBoard || !blastPieces) return;
  blastScoreEl.textContent = blastState.score;
  if(btnBlastFinish) btnBlastFinish.disabled = !!blastState.ended || blastState.score <= 0 || !!blastState.submitting;
  blastBestEl.textContent = Math.max(Number(localStorage.getItem(userScopedKey(BLAST_BEST_KEY))||0), blastState.score);
  blastBoard.innerHTML = '';
  for(let r=0;r<BLAST_SIZE;r++) for(let c=0;c<BLAST_SIZE;c++){
    const val=blastState.board[r][c];
    const cell=document.createElement('button'); cell.type='button'; cell.className='blastCell'+(val?' filled color-'+val:''); cell.dataset.r=r; cell.dataset.c=c;
    cell.addEventListener('click',()=>blastPlaceAt(r,c,blastState.selected));
    cell.addEventListener('dragover',(ev)=>{ ev.preventDefault(); const raw=ev.dataTransfer?.getData('text/plain'); const idx=Number(raw || blastState.dragging); if(Number.isFinite(idx)) blastPreview(idx,r,c); });
    cell.addEventListener('dragleave',()=>blastClearHints());
    cell.addEventListener('drop',(ev)=>{ ev.preventDefault(); const raw=ev.dataTransfer?.getData('text/plain'); const idx=Number(raw || blastState.dragging); blastClearHints(); if(Number.isFinite(idx)) blastPlaceAt(r,c,idx); });
    cell.addEventListener('pointerenter',()=>{ if(blastState.dragging>=0) blastPreview(blastState.dragging,r,c); });
    cell.addEventListener('pointerup',()=>{ if(blastState.dragging>=0){ const idx=blastState.dragging; blastState.dragging=-1; blastClearHints(); blastPlaceAt(r,c,idx); } });
    blastBoard.appendChild(cell);
  }
  blastPieces.innerHTML='';
  blastState.pieces.forEach((piece,i)=>{
    const shape=blastPieceShape(piece), color=blastPieceColor(piece);
    const box=document.createElement('button'); box.type='button'; box.className='blastPiece color-'+color+(blastState.selected===i?' active':'')+(piece?'':' used'); box.dataset.piece=i;
    if(piece){
      box.draggable=true; box.style.gridTemplateColumns='repeat('+shape[0].length+', 20px)';
      shape.flat().forEach(v=>{ const b=document.createElement('span'); b.className='blastMini'+(v?' on color-'+color:''); box.appendChild(b); });
      box.addEventListener('dragstart',(ev)=>{ blastState.selected=i; blastState.dragging=i; ev.dataTransfer?.setData('text/plain',String(i)); ev.dataTransfer.effectAllowed='move'; box.classList.add('dragging'); });
      box.addEventListener('dragend',()=>{ blastState.dragging=-1; blastClearHints(); box.classList.remove('dragging'); });
      box.addEventListener('pointerdown',(ev)=>{ blastState.selected=i; blastState.dragging=i; box.setPointerCapture?.(ev.pointerId); });
    } else box.textContent='✓';
    box.addEventListener('click',()=>{ if(piece){ blastState.selected=i; setMsg(blastMsg,'Parçayı tahtaya sürükle veya boş kareye tıkla.'); blastRender(); }});
    blastPieces.appendChild(box);
  });
}
function blastPlaceAt(r,c,index=blastState.selected){
  if(blastState.ended){ setMsg(blastMsg,'Bu oyun bitti. Yeni Oyun ile tekrar başla.'); return; }
  const piece=blastState.pieces[index]; const shape=blastPieceShape(piece); const color=blastPieceColor(piece);
  if(!shape){ setMsg(blastMsg,'Önce bir parçayı sürükle veya seç.'); return; }
  if(!blastCanPlace(piece,r,c)){ setMsg(blastMsg,'❌ Buraya sığmıyor. Başka bir boşluk dene.'); return; }
  let blocks=0; for(let y=0;y<shape.length;y++) for(let x=0;x<shape[y].length;x++) if(shape[y][x]){ blastState.board[r+y][c+x]=color; blocks++; }
  const beforeBest = Number(localStorage.getItem(userScopedKey(BLAST_BEST_KEY))||0);
  blastState.score += blocks*12;
  const fullRows=[], fullCols=[];
  for(let i=0;i<BLAST_SIZE;i++){ if(blastState.board[i].every(Boolean)) fullRows.push(i); if(blastState.board.every(row=>row[i])) fullCols.push(i); }
  const cleared=fullRows.length+fullCols.length;
  fullRows.forEach(rr=>blastState.board[rr].fill(null)); fullCols.forEach(cc=>blastState.board.forEach(row=>row[cc]=null));
  if(cleared){ blastState.combo += 1; blastState.score += cleared*150 + (cleared>1?(cleared-1)*110:0) + blastState.combo*35; arcadeToast(blastState.combo>1 ? 'COMBO x'+blastState.combo+'!' : 'İlk patlama!'); arcadeFireworks(blastState.combo>1 ? 20 : 14); }
  else blastState.combo = 0;
  blastState.pieces[index]=null; blastState.selected = blastState.pieces.findIndex(Boolean);
  if(!blastState.pieces.some(Boolean)){ blastState.pieces=blastNewPieces(); blastState.selected=0; blastState.score+=75; setMsg(blastMsg,'🎁 Yeni üçlü geldi! +75 bonus'); }
  else setMsg(blastMsg, cleared ? '💥 '+cleared+' satır/sütun patladı! Combo x'+blastState.combo : 'Güzel hamle! Sıradaki parçayı sürükle.');
  blastRender();
  arcadeBump(blastScoreEl);
  if(beforeBest > 0 && blastState.score > beforeBest){ localStorage.setItem(userScopedKey(BLAST_BEST_KEY), String(blastState.score)); arcadeToast('🎉 Yeni rekor!', 'record'); arcadeFireworks(24); }
  if(!blastHasMove()) blastGameOver();
}
async function blastGameOver(manual=false){
  if(blastState.submitting) return;
  blastState.ended = true;
  const best = Math.max(Number(localStorage.getItem(userScopedKey(BLAST_BEST_KEY))||0), blastState.score); localStorage.setItem(userScopedKey(BLAST_BEST_KEY), String(best));
  if(blastState.score <= 0){ blastRender(); arcadeRestartMessage(blastMsg, 'Puanın 0 olduğu için sıralamaya eklenmedi.', 'Tekrar Başlat', 'blastNewGame'); return; }
  blastState.submitting = true;
  blastRender();
  setMsg(blastMsg, (manual?'🏁 Oyunu bitirdin. ':'🏁 Hamle kalmadı. ')+'Puanın: '+blastState.score+'. Sıralamaya kaydediliyor...');
  if(!manual){ arcadeToast('Oyun bitti!', 'hot'); }
  try{ await api('blast_score_submit','POST',{score:blastState.score, game:'blast'}); await loadBlastLeaderboard(); arcadeRestartMessage(blastMsg, '✅ Puan sıralamaya kaydedildi. Dereceni sağdan görebilirsin.', 'Tekrar Oyna', 'blastNewGame'); }catch(e){ arcadeRestartMessage(blastMsg, 'Puan yerel kaydedildi. Sunucu: '+e.message, 'Tekrar Oyna', 'blastNewGame'); }
  finally{ blastState.submitting=false; blastRender(); }
}
function blastNewGame(){ blastState.board=blastEmptyBoard(); blastState.pieces=blastNewPieces(); blastState.selected=0; blastState.score=0; blastState.combo=0; blastState.dragging=-1; blastState.ended=false; blastState.submitting=false; setMsg(blastMsg,'Parçayı tut, tahtaya sürükle ve bırak. Satır/sütun tamamlayınca patlar.'); blastRender(); }
function renderBlastLeaderboard(data){
  if(!blastLeaderboard) return; const items=data.items||[];
  if($('arcadeRankTitle')) $('arcadeRankTitle').textContent = (blastState.activeGame === 'm2' ? 'M2 Blocks' : 'MEra Blast') + ' dereceleri';
  blastMyRank.innerHTML = 'Senin sıran: <b>'+(data.my_rank ? '#'+data.my_rank : 'henüz yok')+'</b> • En iyi puanın: <b>'+(data.my_score||0)+'</b>';
  blastLeaderboard.innerHTML = items.length ? items.map((x,i)=>'<div class="blastRankRow '+(x.is_me?'me':'')+'"><b>#'+(i+1)+'</b><span>'+escapeHtml(x.full_name||'Oyuncu')+'<small>'+escapeHtml(x.school||'')+'</small></span><strong>'+Number(x.best_score||0)+'</strong></div>').join('') : '<div class="muted">Henüz skor yok. İlk dereceyi sen yap.</div>';
}
async function loadBlastLeaderboard(){
  try{ const d=await api(blastState.activeGame === 'm2' ? 'm2_leaderboard' : 'blast_leaderboard','GET',{scope:blastState.rankScope, game:blastState.activeGame}); renderBlastLeaderboard(d); }catch(e){ if(blastLeaderboard) blastLeaderboard.innerHTML='<div class="muted">Sıralama yüklenemedi: '+escapeHtml(e.message)+'</div>'; }
}
async function loadBlast(){ if(!blastState.loaded){ blastNewGame(); m2NewGame(); blastState.loaded=true; } else { blastRender(); m2Render(); } await loadBlastLeaderboard(); }

// --- M2 Blocks mini game ---
const M2_SIZE = 5;
const M2_BEST_KEY = 'mera_m2_best_score';
let m2State = { board: [], pieces: [], selected: -1, score: 0, combo: 0, dragging: -1, ended: false, submitting: false, turns: 0 };
function m2Els(){ return { board:$('m2Board'), pieces:$('m2Pieces'), score:$('m2Score'), best:$('m2Best'), msg:$('m2Msg'), finish:$('btnM2Finish') }; }
function m2EmptyBoard(){ return Array.from({length:M2_SIZE},()=>Array(M2_SIZE).fill(0)); }
function m2CurrentMax(){
  const boardMax = Math.max(2, ...m2State.board.flat());
  const scoreTier = Math.pow(2, Math.min(10, 3 + Math.floor((m2State.score||0) / 650)));
  return Math.max(8, boardMax, scoreTier);
}
function m2WeightedValue(){
  const max = m2CurrentMax();
  const minPlayable = max >= 64 ? Math.max(4, max / 16) : 2;
  const values = [];
  for(let v=2; v<=max; v*=2) if(v>=minPlayable) values.push(v);
  const turnBoost = Math.min(values.length-1, Math.floor((m2State.turns||0) / 6));
  const idx = Math.min(values.length-1, Math.max(0, Math.floor(Math.random()*Math.min(values.length, 3 + turnBoost))));
  const rareBig = (m2State.turns||0) > 8 && Math.random() < Math.min(.38, .10 + (m2State.turns||0)*.012);
  return rareBig ? values[Math.min(values.length-1, idx+1)] : values[idx];
}
function m2NewPieces(){
  const vals = Array.from({length:3},()=>m2WeightedValue());
  if(vals.every(v=>v===vals[0])){
    vals[2] = Math.min(m2CurrentMax(), Math.max(2, vals[2] * 2));
  }
  vals.sort((a,b)=>a-b);
  return vals;
}
function m2Neighbors(r,c){ return [[r-1,c],[r+1,c],[r,c-1],[r,c+1]].filter(([y,x])=>y>=0&&x>=0&&y<M2_SIZE&&x<M2_SIZE); }
function m2HasMove(){ return m2State.pieces.some(v=>v && m2State.board.some(row=>row.some(cell=>!cell))); }
function m2ClearHints(){ m2Els().board?.querySelectorAll('.m2CanDrop,.m2BadDrop').forEach(el=>el.classList.remove('m2CanDrop','m2BadDrop')); }
function m2Preview(i,r,c){ m2ClearHints(); const el=m2Els().board?.querySelector('[data-r="'+r+'"][data-c="'+c+'"]'); if(el) el.classList.add(!m2State.board[r][c]?'m2CanDrop':'m2BadDrop'); }
function m2Render(){
  const e=m2Els(); if(!e.board || !e.pieces) return;
  e.score.textContent = m2State.score;
  e.best.textContent = Math.max(Number(localStorage.getItem(userScopedKey(M2_BEST_KEY))||0), m2State.score);
  if(e.finish) e.finish.disabled = !!m2State.ended || m2State.score <= 0 || !!m2State.submitting;
  e.board.innerHTML='';
  for(let r=0;r<M2_SIZE;r++) for(let c=0;c<M2_SIZE;c++){
    const val=m2State.board[r][c]; const cell=document.createElement('button'); cell.type='button'; cell.className='m2Cell'+(val?' filled v'+Math.min(2048,val):''); cell.dataset.r=r; cell.dataset.c=c; cell.textContent=val || '';
    cell.addEventListener('click',()=>m2PlaceAt(r,c,m2State.selected));
    cell.addEventListener('dragover',(ev)=>{ ev.preventDefault(); const idx=Number(ev.dataTransfer?.getData('text/plain') || m2State.dragging); if(Number.isFinite(idx)) m2Preview(idx,r,c); });
    cell.addEventListener('dragleave',m2ClearHints);
    cell.addEventListener('drop',(ev)=>{ ev.preventDefault(); const idx=Number(ev.dataTransfer?.getData('text/plain') || m2State.dragging); m2ClearHints(); if(Number.isFinite(idx)) m2PlaceAt(r,c,idx); });
    cell.addEventListener('pointerenter',()=>{ if(m2State.dragging>=0) m2Preview(m2State.dragging,r,c); });
    cell.addEventListener('pointerup',()=>{ if(m2State.dragging>=0){ const idx=m2State.dragging; m2State.dragging=-1; m2ClearHints(); m2PlaceAt(r,c,idx); } });
    e.board.appendChild(cell);
  }
  e.pieces.innerHTML='';
  m2State.pieces.forEach((val,i)=>{ const b=document.createElement('button'); b.type='button'; b.className='m2Piece'+(m2State.selected===i?' active':'')+(val?'':' used'); b.dataset.piece=i; b.textContent=val || '✓'; if(val){ b.draggable=true; b.addEventListener('dragstart',(ev)=>{m2State.selected=i; m2State.dragging=i; ev.dataTransfer?.setData('text/plain',String(i)); b.classList.add('dragging');}); b.addEventListener('dragend',()=>{m2State.dragging=-1; m2ClearHints(); b.classList.remove('dragging');}); b.addEventListener('pointerdown',(ev)=>{m2State.selected=i; m2State.dragging=i; b.setPointerCapture?.(ev.pointerId);}); } b.addEventListener('click',()=>{ if(val){m2State.selected=i; setMsg(e.msg,'Bloğu tahtadaki boş bir kareye sürükle.'); m2Render();} }); e.pieces.appendChild(b); });
}
function m2Resolve(r,c){
  let merged=0, changed=true;
  while(changed){
    changed=false; const val=m2State.board[r][c]; if(!val) break;
    const match=m2Neighbors(r,c).find(([y,x])=>m2State.board[y][x]===val);
    if(match){ const [y,x]=match; m2State.board[y][x]=0; m2State.board[r][c]=val*2; m2State.score += val*3; merged++; changed=true; }
  }
  return merged;
}
function m2PlaceAt(r,c,index=m2State.selected){
  const e=m2Els(); if(m2State.ended){ setMsg(e.msg,'Bu oyun bitti. Yeni Oyun ile tekrar başla.'); return; }
  const val=m2State.pieces[index]; if(!val){ setMsg(e.msg,'Önce bir M2 bloğu seç.'); return; }
  if(m2State.board[r][c]){ setMsg(e.msg,'❌ Bu kare dolu. Boş bir kare dene.'); return; }
  const beforeBest = Number(localStorage.getItem(userScopedKey(M2_BEST_KEY))||0);
  m2State.turns = (m2State.turns||0) + 1;
  m2State.board[r][c]=val; m2State.score += val*10;
  const merged=m2Resolve(r,c);
  if(merged){ m2State.combo++; m2State.score += merged*90 + m2State.combo*40; setMsg(e.msg,'✨ '+merged+' birleşme! Combo x'+m2State.combo); arcadeToast('COMBO x'+m2State.combo+'!', m2State.combo>1?'hot':''); arcadeFireworks(m2State.combo>1 ? 18 : 12); }
  else { m2State.combo=0; setMsg(e.msg, m2State.turns%5===0 ? 'Tempo iyi! Büyük sayıları yan yana toplamaya devam.' : 'Güzel hamle! Aynı sayıları yan yana getir.'); }
  m2State.pieces[index]=0; m2State.selected=m2State.pieces.findIndex(Boolean);
  if(!m2State.pieces.some(Boolean)){ m2State.pieces=m2NewPieces(); m2State.selected=0; m2State.score+=50; setMsg(e.msg,'🎲 Yeni M2 blokları geldi! +50 bonus'); }
  m2Render(); arcadeBump(e.score);
  if(beforeBest > 0 && m2State.score > beforeBest){ localStorage.setItem(userScopedKey(M2_BEST_KEY), String(m2State.score)); arcadeToast('🎉 Yeni rekor!', 'record'); arcadeFireworks(24); }
  if(!m2HasMove()) m2GameOver();
}
async function m2GameOver(manual=false){
  const e=m2Els(); if(m2State.submitting) return; m2State.ended=true; const best=Math.max(Number(localStorage.getItem(userScopedKey(M2_BEST_KEY))||0),m2State.score); localStorage.setItem(userScopedKey(M2_BEST_KEY),String(best));
  if(m2State.score<=0){ m2Render(); arcadeRestartMessage(e.msg, 'Puanın 0 olduğu için sıralamaya eklenmedi.', 'Tekrar Başlat', 'm2NewGame'); return; }
  m2State.submitting=true; m2Render(); setMsg(e.msg,(manual?'🏁 Oyunu bitirdin. ':'🏁 Hamle kalmadı. ')+'Puanın kaydediliyor: '+m2State.score);
  if(!manual){ arcadeToast('Oyun bitti!', 'hot'); }
  try{ await api('m2_score_submit','POST',{score:m2State.score, game:'m2'}); if(blastState.activeGame==='m2') await loadBlastLeaderboard(); arcadeRestartMessage(e.msg, '✅ M2 Blocks puanın sıralamaya kaydedildi.', 'Tekrar Oyna', 'm2NewGame'); }catch(err){ arcadeRestartMessage(e.msg, 'Puan yerel kaydedildi. Sunucu: '+err.message, 'Tekrar Oyna', 'm2NewGame'); }
  finally{ m2State.submitting=false; m2Render(); }
}
function m2NewGame(){ m2State.board=m2EmptyBoard(); m2State.pieces=m2NewPieces(); m2State.selected=0; m2State.score=0; m2State.combo=0; m2State.turns=0; m2State.dragging=-1; m2State.ended=false; m2State.submitting=false; setMsg(m2Els().msg,'M2 bloğunu sürükle. Aynı sayılar birleşir, büyük sayı daha çok puan verir.'); m2Render(); }
window.blastNewGame = blastNewGame;
window.m2NewGame = m2NewGame;
function switchArcadeGame(game){
  blastState.activeGame = game === 'm2' ? 'm2' : 'blast';
  document.querySelectorAll('[data-arcade-game]').forEach(b=>b.classList.toggle('active', b.dataset.arcadeGame===blastState.activeGame));
  document.querySelectorAll('[data-game-panel]').forEach(p=>p.classList.toggle('active', p.dataset.gamePanel===blastState.activeGame));
  loadBlastLeaderboard();
}

function bindBlast(){
  btnBackBlast?.addEventListener('click',()=>navigateSimpleMenu('directory'));
  btnBlastNew?.addEventListener('click',blastNewGame);
  btnBlastFinish?.addEventListener('click',()=>blastGameOver(true));
  $('btnM2New')?.addEventListener('click',m2NewGame);
  $('btnM2Finish')?.addEventListener('click',()=>m2GameOver(true));
  document.querySelectorAll('[data-arcade-game]').forEach(btn=>btn.addEventListener('click',()=>switchArcadeGame(btn.dataset.arcadeGame))); 
  document.addEventListener('pointerup',(ev)=>{
    if(blastState.dragging < 0 || !blastBoard || !blastCard || blastCard.classList.contains('hidden') || blastState.activeGame !== 'blast') return;
    const idx = blastState.dragging;
    blastState.dragging = -1;
    blastClearHints();
    const el = document.elementFromPoint(ev.clientX, ev.clientY);
    const cell = el?.closest?.('.blastCell');
    if(cell && blastBoard.contains(cell)){ blastPlaceAt(Number(cell.dataset.r), Number(cell.dataset.c), idx); }
  }, true);
  document.addEventListener('pointerup',(ev)=>{
    const e=m2Els(); if(m2State.dragging < 0 || !e.board || !blastCard || blastCard.classList.contains('hidden') || blastState.activeGame !== 'm2') return;
    const idx=m2State.dragging; m2State.dragging=-1; m2ClearHints();
    const el=document.elementFromPoint(ev.clientX, ev.clientY); const cell=el?.closest?.('.m2Cell');
    if(cell && e.board.contains(cell)){ m2PlaceAt(Number(cell.dataset.r), Number(cell.dataset.c), idx); }
  }, true);
  document.querySelectorAll('[data-blast-rank]').forEach(btn=>btn.addEventListener('click',()=>{ document.querySelectorAll('[data-blast-rank]').forEach(b=>b.classList.toggle('active',b===btn)); blastState.rankScope=btn.dataset.blastRank||'school'; loadBlastLeaderboard(); }));
}

try{ bindPetUi(); }catch(_){}
