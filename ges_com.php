<?php
/**
 * GESCOM - Lead Capture Popup Email Handler
 * develop-it
 */

$popupEmailSent = false;
$popupError     = '';
$leadCaptured   = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_popup'])) {

    $name  = htmlspecialchars(strip_tags(trim($_POST['popup_name']  ?? '')));
    $email = filter_var(trim($_POST['popup_email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(strip_tags(trim($_POST['popup_phone'] ?? '')));
    $lang  = htmlspecialchars(strip_tags(trim($_POST['popup_lang']  ?? 'fr')));

    if (empty($name) || empty($email) || empty($phone)) {
        $popupError = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $popupError = 'Adresse email invalide.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '📩 Nouveau lead GESCOM - ' . $name . ' | develop-it.tech';

        $body  = "Nouvelle demande d'accès GESCOM\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Nom       : $name\n";
        $body .= "📧 Email     : $email\n";
        $body .= "📞 Téléphone : $phone\n";
        $body .= "🌐 Langue    : " . strtoupper($lang) . "\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "Envoyé le : " . date('d/m/Y à H:i') . "\n";
        $body .= "IP        : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@develop-it.tech\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $popupEmailSent = true;
            $leadCaptured   = true;
            // Set cookie so popup doesn't reappear for 30 days
            setcookie('gescom_lead', '1', time() + (86400 * 30), '/');
        } else {
            $popupError = 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer.';
        }
    }
}

// Also check if cookie is set (returning visitor)
if (isset($_COOKIE['gescom_lead'])) {
    $leadCaptured = true;
}

// Convert PHP booleans to JS-safe strings
$js_leadCaptured   = $leadCaptured   ? 'true'  : 'false';
$js_popupEmailSent = $popupEmailSent ? 'true'  : 'false';
$js_popupError     = $popupError     ? json_encode($popupError) : 'false';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <title>GESCOM | develop-it | Solution ERP Complète pour la Gestion d'Entreprise</title>
  <meta charset="UTF-8">
  <meta name="description" content="GESCOM par DEVELOP IT - Solution ERP de référence pour entreprises modernes. Gestion multi-sociétés, multi-devises, BI avancée au Maroc.">
  <meta name="keywords" content="DEVELOP IT, gescom, erp, gestion entreprise, multi-sociétés, comptabilité, stocks, crm, maroc">
  <meta name="author" content="DEVELOP IT">
  <meta name="robots" content="index, follow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="canonical" href="https://develop-it.tech/gescom_landing.php">

  <meta property="og:type" content="website">
  <meta property="og:url" content="https://develop-it.tech/gescom_landing.php">
  <meta property="og:title" content="GESCOM | DEVELOP IT - Solution ERP Complète">
  <meta property="og:description" content="Solution ERP de référence développée par develop-it.">
  <meta property="og:site_name" content="DEVELOP IT">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="GESCOM | DEVELOP IT">
  <meta name="twitter:description" content="Solution ERP de référence pour entreprises modernes">

  <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
  <link rel="icon" type="image/png" sizes="16x16" href="/logo.jfif">
  <link rel="apple-touch-icon" href="/logo.jfif">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .selection\:bg-teal-100::selection { background-color: #CCFBF1; }
    .selection\:text-teal-900::selection { color: #134E4A; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
  </style>

  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <script>
    // ── PHP → JS bridge ──────────────────────────────────────────────
    window.gescomLeadCaptured = <?php echo $js_leadCaptured; ?>;
    window.popupEmailSent     = <?php echo $js_popupEmailSent; ?>;
    window.popupError         = <?php echo $js_popupError; ?>;
  </script>
</head>

<body class="bg-white text-slate-900">
  <div id="root"></div>

  <script type="text/babel">
    setTimeout(() => {
      const { useState, useEffect } = React;

      // Icon wrappers
      const ArrowRight  = (props) => <i data-lucide="arrow-right"   {...props}></i>;
      const ChevronRight= (props) => <i data-lucide="chevron-right"  {...props}></i>;
      const Globe       = (props) => <i data-lucide="globe"          {...props}></i>;
      const User        = (props) => <i data-lucide="user"           {...props}></i>;
      const Lock        = (props) => <i data-lucide="lock"           {...props}></i>;
      const Quote       = (props) => <i data-lucide="quote"          {...props}></i>;
      const LayoutGrid  = (props) => <i data-lucide="layout-grid"    {...props}></i>;
      const BarChart3   = (props) => <i data-lucide="bar-chart-3"    {...props}></i>;
      const TrendingUp  = (props) => <i data-lucide="trending-up"    {...props}></i>;
      const Package     = (props) => <i data-lucide="package"        {...props}></i>;
      const Bell        = (props) => <i data-lucide="bell"           {...props}></i>;
      const Users       = (props) => <i data-lucide="users"          {...props}></i>;
      const Briefcase   = (props) => <i data-lucide="briefcase"      {...props}></i>;
      const Truck       = (props) => <i data-lucide="truck"          {...props}></i>;
      const Box         = (props) => <i data-lucide="box"            {...props}></i>;
      const Wallet      = (props) => <i data-lucide="wallet"         {...props}></i>;
      const PieChart    = (props) => <i data-lucide="pie-chart"      {...props}></i>;
      const Home        = (props) => <i data-lucide="home"           {...props}></i>;
      const Settings    = (props) => <i data-lucide="settings"       {...props}></i>;
      const Building2   = (props) => <i data-lucide="building-2"     {...props}></i>;
      const FileText    = (props) => <i data-lucide="file-text"      {...props}></i>;
      const CheckCircle = (props) => <i data-lucide="check-circle"   {...props}></i>;
      const AlertCircle = (props) => <i data-lucide="alert-circle"   {...props}></i>;
      const ArrowLeft   = (props) => <i data-lucide="arrow-left"     {...props}></i>;

      // Logo
      const Logo = ({ variant = 'standard', className = "h-12", showWordmark = true }) => {
        const isDark  = variant === 'inverted';
        const navy    = isDark ? '#FFFFFF' : '#111827';
        const teal    = '#0D9488';
        const iconBg  = isDark ? 'rgba(255,255,255,0.1)' : '#F3F4F6';
        return (
          <div className={`flex items-center gap-4 ${className}`} dir="ltr">
            <svg viewBox="0 0 450 100" fill="none" xmlns="http://www.w3.org/2000/svg" className="h-full w-auto flex-shrink-0">
              <rect x="0" y="0" width="100" height="100" rx="22" fill={iconBg} />
              <path d="M20 32C20 22.6112 27.6112 15 37 15H80V45H20V32Z" fill={isDark ? '#FFFFFF' : '#0F172A'} />
              <path d="M15 25V85H30C24.4772 85 20 80.5228 20 75V25H15Z" fill={isDark ? '#FFFFFF' : '#0F172A'} />
              <circle cx="45" cy="55" r="7" fill={isDark ? '#FFFFFF' : '#0F172A'} />
              <rect x="70" y="47" width="20" height="20" rx="2" fill={teal} />
              <rect x="25" y="70" width="38" height="14" rx="2" fill={isDark ? 'rgba(255,255,255,0.4)' : '#334155'} />
              <rect x="70" y="70" width="20" height="14" rx="2" fill={isDark ? 'rgba(255,255,255,0.2)' : '#94A3B8'} />
              {showWordmark && (
                <g transform="translate(130, 72)">
                  <text style={{ fontFamily: 'Inter, sans-serif', fontWeight: 800, fontSize: '72px', letterSpacing: '-0.02em' }}>
                    <tspan fill={navy}>GES</tspan>
                    <tspan fill="transparent" style={{ fontSize: '30px' }}> </tspan>
                    <tspan fill={teal}>COM</tspan>
                  </text>
                </g>
              )}
            </svg>
          </div>
        );
      };

      // Platform Mockup
      const PlatformMockup = () => {
        useEffect(() => { if (window.lucide) lucide.createIcons(); }, []);
        return (
          <div className="w-full bg-slate-50 border border-slate-200 rounded-[2rem] shadow-2xl overflow-hidden mt-20 group">
            <div className="bg-[#0f172a] text-white px-6 py-3 flex items-center justify-between overflow-x-auto whitespace-nowrap scrollbar-hide">
              <div className="flex items-center gap-6">
                <Logo showWordmark={true} variant="inverted" className="h-6" />
                <div className="flex items-center gap-4 text-[11px] font-medium opacity-80">
                  <span className="flex items-center gap-1.5"><Home size={14} /> Tableau de bord</span>
                  <span className="flex items-center gap-1.5"><Users size={14} /> Clients</span>
                  <span className="flex items-center gap-1.5"><Briefcase size={14} /> CRM</span>
                  <span className="flex items-center gap-1.5"><Truck size={14} /> Fournisseurs</span>
                  <span className="flex items-center gap-1.5"><Box size={14} /> Stocks</span>
                  <span className="flex items-center gap-1.5"><Users size={14} /> Personnel</span>
                  <span className="flex items-center gap-1.5"><Wallet size={14} /> Finances</span>
                  <span className="flex items-center gap-1.5"><PieChart size={14} /> BI & Reporting</span>
                  <span className="flex items-center gap-1.5"><FileText size={14} /> Immobilisations</span>
                  <span className="flex items-center gap-1.5"><Building2 size={14} /> Business Units</span>
                  <span className="flex items-center gap-1.5"><Settings size={14} /> Administration</span>
                </div>
              </div>
              <div className="flex items-center gap-4 text-[11px] font-medium opacity-80 ml-4">
                <span className="flex items-center gap-1.5"><Globe size={14} /> FR</span>
                <span className="flex items-center gap-1.5"><User size={14} /> OrionSA Admin</span>
              </div>
            </div>
            <div className="p-10 min-h-[500px]">
              <div className="text-center mb-12">
                <h2 className="text-2xl font-bold text-slate-800">Bienvenue, Admin OrionSA</h2>
                <p className="text-slate-500 font-medium">Société: OrionSA • Solution développée par <strong className="text-teal-600">DEVELOP IT</strong></p>
              </div>
              <div className="max-w-6xl mx-auto">
                <div className="mb-8">
                  <h3 className="text-xl font-bold text-slate-800 mb-1">Pilotage & analyse</h3>
                  <p className="text-sm text-slate-500">Suivez les indicateurs clés et anticipez les actions à mener.</p>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                  {[
                    { color: 'yellow', icon: <Bell className="text-yellow-400 mb-4" size={32} />, title: 'Alertes opérationnelles', desc: 'Consultez les alertes critiques sur les budgets, livraisons et échéances.' },
                    { color: 'blue',   icon: <TrendingUp className="text-blue-500 mb-4" size={32} />, title: 'Reporting global', desc: 'Analysez la performance globale de l\'entreprise et des BU.' },
                    { color: 'cyan',   icon: <LayoutGrid className="text-cyan-400 mb-4" size={32} />, title: 'Reporting BU', desc: 'Visualisez l\'avancement et la rentabilité détaillée des BU.' },
                    { color: 'green',  icon: <BarChart3 className="text-green-600 mb-4" size={32} />, title: 'Coûts & progression', desc: 'Comparez les coûts réels vs prévisionnels pour garder le contrôle.' },
                    { color: 'slate',  icon: <PieChart className="text-slate-400 mb-4" size={32} />, title: 'BI & dataviz', desc: 'Explorez les tableaux de bord interactifs et analyses avancées.' },
                  ].map((card, i) => (
                    <div key={i} className={`bg-white p-6 rounded-2xl border-l-4 border-${card.color}-${card.color === 'green' ? '600' : card.color === 'slate' ? '400' : card.color === 'yellow' ? '400' : card.color === 'blue' ? '500' : '400'} shadow-sm flex flex-col justify-between hover:translate-y-[-4px] transition-transform`}>
                      <div>{card.icon}<h4 className="font-bold text-slate-800 text-sm mb-2">{card.title}</h4><p className="text-[11px] text-slate-500 leading-relaxed mb-6">{card.desc}</p></div>
                      <button className={`w-fit border border-${card.color}-${card.color === 'green' ? '600' : card.color === 'slate' ? '400' : card.color === 'yellow' ? '400' : card.color === 'blue' ? '500' : '400'} text-${card.color}-${card.color === 'green' ? '700' : card.color === 'slate' ? '600' : card.color === 'yellow' ? '500' : card.color === 'blue' ? '600' : '500'} px-4 py-1.5 rounded-lg text-xs font-bold transition-colors`}>Accéder</button>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        );
      };

      // ── Content ──────────────────────────────────────────────────────
      const CONTENT = {
        en: { navSolutions:"Solutions",navModules:"Modules",navPricing:"Pricing",navClientPortal:"Client Portal",heroLabel:"GESCOM Global Enterprise Standard",heroTitle:"Unified Control for Global Expansion.",heroSub:"The premier ERP ecosystem for modern business mastery. GESCOM synchronizes your entire operation with absolute precision and unmatched scale.",ctaMain:"Start Your Journey",ctaSub:"View Solutions",modulesTitle:"Modular Enterprise Architecture",modulesDesc:"A powerful, unified engine designed for multi-entity and multi-currency environments. Scale without limits.",learnMore:"Learn more",systemDetails:"Module Overview",testimonialsTitle:"Industry Insights",testimonials:[{quote:"GESCOM transformed our cross-border financial reconciliation. It is the gold standard.",author:"Sarah Jenkins",company:"CFO, NexaGlobal"},{quote:"Efficiency increased by 40% in our logistics hub within 6 months of deployment.",author:"Ahmed Al-Farsi",company:"Logistics Director"},{quote:"Absolute control over our multi-warehouse inventory. A game changer for 2026.",author:"Marcus Thorne",company:"CEO, Apex Systems"}],trustSection:"Trusted by Global Leaders from Riyadh to Paris & Casablanca",footerTagline:"Architecting the Future of Business Control.",footerCol1Title:"Core Modules",footerCol2Title:"Enterprise",footerFunctions:["Inventory Management","Financial Accounting","Procurement Cycle","Project Management"],footerEnterprise:["Role-Based Security","Advanced Auditing","External API","Dedicated Support"],footerCopyright:"© 2026 GESCOM GLOBAL. All Rights Reserved.",footerLinks:["Privacy","Compliance","Terms"],popupTitle:"Executive Access",popupSub:"Enter your professional details to access the full GESCOM Briefing.",popupName:"Full Name",popupEmail:"Professional Email",popupPhone:"Phone Number",popupSubmit:"Request Access",popupPrivacy:"Global SLA standards compliant.",popupSuccessTitle:"✅ Request sent successfully!",popupSuccessMsg:"The DEVELOP IT team will contact you shortly.",features:[{title:"Financial Mastery",description:"Automated multi-currency ledgers and real-time tax compliance engines.",icon:"finance"},{title:"Supply Chain Velocity",description:"End-to-end procurement and multi-warehouse logistics synchronization.",icon:"supply"},{title:"Strategic Intelligence",description:"Executive BI dashboards with predictive forecasting and data mastery.",icon:"bi"},{title:"Operational Control",description:"Unified command center for multi-entity corporate governance.",icon:"ops"}] },
        fr: { navSolutions:"Solutions",navModules:"Modules",navPricing:"Tarifs",navClientPortal:"Espace Client",heroLabel:"GESCOM : Le Standard de Gestion",heroTitle:"Le Contrôle Unifié pour votre Expansion.",heroSub:"L'écosystème ERP de référence pour la maîtrise des entreprises modernes. GESCOM synchronise vos opérations avec une précision absolue.",ctaMain:"Commencer",ctaSub:"Voir les Solutions",modulesTitle:"Architecture Entreprise Modulaire",modulesDesc:"Un moteur puissant et unifié conçu pour les environnements multi-sociétés et multi-devises.",learnMore:"En savoir plus",systemDetails:"Aperçu des Modules",testimonialsTitle:"Retours d'Expérience",testimonials:[{quote:"GESCOM a transformé notre réconciliation financière internationale. C'est la référence.",author:"Sarah Jenkins",company:"CFO, NexaGlobal"},{quote:"L'efficacité a augmenté de 40% dans nos hubs logistiques après 6 mois.",author:"Ahmed Al-Farsi",company:"Directeur Logistique"},{quote:"Une maîtrise absolue de nos stocks multi-entrepôts.",author:"Jean Dupont",company:"CEO, TechEurope"}],trustSection:"Approuvé par des leaders mondiaux de Riyad à Paris et Casablanca",footerTagline:"L'Architecte du Contrôle en Entreprise.",footerCol1Title:"Modules Cœur",footerCol2Title:"Entreprise",footerFunctions:["Gestion des Stocks","Comptabilité Finance","Cycle Achat","Gestion de Projets"],footerEnterprise:["Sécurité par Rôles","Audit Avancé","API Externe","Support Dédié"],footerCopyright:"© 2026 GESCOM GLOBAL. Tous droits réservés.",footerLinks:["Confidentialité","Conformité","Conditions"],popupTitle:"Accès Privilégié",popupSub:"Renseignez vos informations pour accéder à la présentation complète.",popupName:"Nom Complet",popupEmail:"Email Professionnel",popupPhone:"Téléphone",popupSubmit:"Demander l'Accès",popupPrivacy:"Conforme aux standards SLA mondiaux.",popupSuccessTitle:"✅ Demande envoyée avec succès !",popupSuccessMsg:"L'équipe DEVELOP IT vous contactera bientôt.",features:[{title:"Maîtrise Financière",description:"Comptabilité multi-devises automatisée et conformité fiscale en temps réel.",icon:"finance"},{title:"Vélocité Logistique",description:"Synchronisation de la chaîne d'approvisionnement de bout en bout.",icon:"supply"},{title:"Intelligence Stratégique",description:"Tableaux de bord BI avec prévisions prédictives.",icon:"bi"},{title:"Contrôle Opérationnel",description:"Centre de commande unifié pour la gouvernance multi-sociétés.",icon:"ops"}] },
        ar: { navSolutions:"حلول",navModules:"وحدات",navPricing:"الأسعار",navClientPortal:"بوابة العملاء",heroLabel:"GESCOM المعيار العالمي للمؤسسات",heroTitle:"تحكم موحد للتوسع العالمي.",heroSub:"نظام تخطيط موارد المؤسسات الرائد لإتقان الأعمال الحديثة. يقوم GESCOM بمزامنة عملياتك بالكامل بدقة مطلقة.",ctaMain:"ابدأ رحلتك",ctaSub:"عرض الحلول",modulesTitle:"هيكلية مؤسسية نمطية",modulesDesc:"محرك قوي وموحد مصمم للبيئات المتعددة الكيانات والمتعددة العملات.",learnMore:"تعرف على المزيد",systemDetails:"نظرة عامة على الوحدات",testimonialsTitle:"رؤى الصناعة",testimonials:[{quote:"لقد أحدث GESCOM تحولاً في تسوياتنا المالية العابرة للحدود.",author:"سارة جينكينز",company:"CFO, NexaGlobal"},{quote:"زادت الكفاءة بنسبة 40% في مركزنا اللوجستي خلال 6 أشهر.",author:"أحمد الفارسي",company:"مدير اللوجستيات"},{quote:"تحكم مطلق في مخزوننا المتعدد المستودعات.",author:"ماركوس ثورن",company:"CEO, Apex Systems"}],trustSection:"موثوق من قادة عالميين من الرياض إلى باريس والدار البيضاء",footerTagline:"هندسة مستقبل التحكم في الأعمال.",footerCol1Title:"الوحدات الأساسية",footerCol2Title:"المؤسسة",footerFunctions:["إدارة المخزون","المحاسبة المالية","دورة المشتريات","إدارة المشاريع"],footerEnterprise:["الأمن القائم على الأدوار","التدقيق المتقدم","واجهة برمجة التطبيقات","دعم مخصص"],footerCopyright:"© 2026 GESCOM GLOBAL. جميع الحقوق محفوظة.",footerLinks:["الخصوصية","الامتثال","الشروط"],popupTitle:"دخول حصري",popupSub:"أدخل بياناتك المهنية للوصول إلى العرض التعريفي الكامل.",popupName:"الاسم الكامل",popupEmail:"البريد الإلكتروني المهني",popupPhone:"رقم الهاتف",popupSubmit:"طلب الدخول",popupPrivacy:"متوافق مع معايير SLA العالمية.",popupSuccessTitle:"✅ تم إرسال الطلب بنجاح!",popupSuccessMsg:"سيتصل بك فريق DEVELOP IT قريباً.",features:[{title:"إتقان مالي",description:"دفاتر حسابات آلية متعددة العملات ومحركات امتثال ضريبي فورية.",icon:"finance"},{title:"سرعة سلسلة التوريد",description:"مزامنة لوجستيات المشتريات والمستودعات المتعددة.",icon:"supply"},{title:"ذكاء استراتيجي",description:"لوحات تحكم ذكاء أعمال مع تنبؤات مستقبلية.",icon:"bi"},{title:"تحكم تشغيلي",description:"مركز قيادة موحد للحوكمة المؤسسية.",icon:"ops"}] }
      };

      const IconMap = {
        finance: <TrendingUp className="w-7 h-7" />,
        supply:  <Package    className="w-7 h-7" />,
        bi:      <BarChart3  className="w-7 h-7" />,
        ops:     <LayoutGrid className="w-7 h-7" />,
      };

      // ── Main Landing Page ─────────────────────────────────────────────
      const LandingPage = ({ lang, onLangChange }) => {
        const content = CONTENT[lang];
        const isRtl   = lang === 'ar';

        // Popup is shown if:
        //  - lead NOT yet captured (no cookie, no prior submission), OR
        //  - email was just sent successfully (to show the success message)
        const [showPopup, setShowPopup] = useState(
          !window.gescomLeadCaptured || window.popupEmailSent
        );
        const [formData, setFormData] = useState({ name: '', email: '', phone: '' });

        useEffect(() => {
          // Auto-hide success popup after 3 seconds
          if (window.popupEmailSent && showPopup) {
            const t = setTimeout(() => setShowPopup(false), 3000);
            return () => clearTimeout(t);
          }
        }, []);

        useEffect(() => {
          if (window.lucide) lucide.createIcons();
        }, [showPopup, lang]);

        const handlePopupSubmit = (e) => {
          if (!formData.name || !formData.email || !formData.phone) {
            e.preventDefault();
          }
          // Otherwise let the PHP POST submit naturally
        };

        return (
          <div className={`bg-white min-h-screen ${showPopup ? 'overflow-hidden' : ''}`} dir={isRtl ? 'rtl' : 'ltr'}>

            {/* ── Popup ── */}
            {showPopup && (
              <div className="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md">
                <div className="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200 relative">

                  {/* Close button */}
                  <button
                    onClick={() => setShowPopup(false)}
                    className="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 transition-all"
                    aria-label="Close"
                  >
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>

                  <div className="bg-slate-900 p-10 text-center">
                    <Logo variant="inverted" className="h-10 mx-auto mb-6" />
                    <h2 className="text-3xl font-bold text-white mb-2">{content.popupTitle}</h2>
                    <p className="text-slate-400 text-sm">{content.popupSub}</p>
                  </div>

                  <div className="p-10 space-y-6">

                    {/* ── Success state ── */}
                    {window.popupEmailSent && (
                      <div className="bg-green-50 border border-green-300 text-green-800 px-6 py-5 rounded-2xl flex items-start gap-4">
                        <svg className="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                          <p className="font-bold text-base">{content.popupSuccessTitle}</p>
                          <p className="text-sm mt-1 opacity-80">{content.popupSuccessMsg}</p>
                        </div>
                      </div>
                    )}

                    {/* ── Error state ── */}
                    {window.popupError && !window.popupEmailSent && (
                      <div className="bg-red-50 border border-red-300 text-red-800 px-6 py-5 rounded-2xl flex items-start gap-4">
                        <svg className="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                          <p className="font-bold">Erreur</p>
                          <p className="text-sm mt-1">{window.popupError}</p>
                        </div>
                      </div>
                    )}

                    {/* ── Form (hidden after success) ── */}
                    {!window.popupEmailSent && (
                      <form method="POST" action="#" onSubmit={handlePopupSubmit} className="space-y-4">
                        <input required type="text" name="popup_name" placeholder={content.popupName}
                          className="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 px-5 text-slate-900 placeholder-slate-400 outline-none focus:ring-2 focus:ring-teal-500 transition-all"
                          value={formData.name} onChange={e => setFormData({...formData, name: e.target.value})} />
                        <input required type="email" name="popup_email" placeholder={content.popupEmail}
                          className="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 px-5 text-slate-900 placeholder-slate-400 outline-none focus:ring-2 focus:ring-teal-500 transition-all"
                          value={formData.email} onChange={e => setFormData({...formData, email: e.target.value})} />
                        <input required type="tel" name="popup_phone" placeholder={content.popupPhone}
                          className="w-full bg-slate-50 border border-slate-200 rounded-xl py-4 px-5 text-slate-900 placeholder-slate-400 outline-none focus:ring-2 focus:ring-teal-500 transition-all"
                          value={formData.phone} onChange={e => setFormData({...formData, phone: e.target.value})} />
                        <input type="hidden" name="popup_lang" value={lang} />

                        <button type="submit" name="submit_popup"
                          className="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-slate-800 transition-all flex items-center justify-center gap-3 shadow-lg">
                          {content.popupSubmit}
                          <ArrowRight size={20} className={isRtl ? 'rotate-180' : ''} />
                        </button>

                        <p className="text-center text-[10px] text-slate-400 uppercase tracking-widest flex items-center justify-center gap-2">
                          <Lock size={12} />
                          {content.popupPrivacy}
                        </p>
                      </form>
                    )}
                  </div>
                </div>
              </div>
            )}

            {/* ── Navbar ── */}
            <nav className="border-b border-slate-100 px-6 py-5 flex justify-between items-center sticky top-0 bg-white/95 backdrop-blur-sm z-50">
              <div className="flex items-center gap-12">
                <a href="/" className="hidden lg:flex items-center gap-2 text-slate-500 hover:text-slate-900 transition text-sm font-semibold">
                  <ArrowLeft size={16} />
                  DEVELOP IT
                </a>
                <Logo className="h-12" />
                <div className="hidden lg:flex gap-8 text-sm font-semibold text-slate-500">
                  <a href="#features"     className="hover:text-slate-900 transition-colors">{content.navSolutions}</a>
                  <a href="#preview"      className="hover:text-slate-900 transition-colors">Platform</a>
                  <a href="#testimonials" className="hover:text-slate-900 transition-colors">{content.testimonialsTitle}</a>
                </div>
              </div>
              <div className="flex items-center gap-6">
                <div className="bg-slate-100/60 p-1 rounded-full flex items-center border border-slate-200 shadow-sm">
                  <Globe size={14} className="text-slate-400 mx-2 hidden sm:block" />
                  <button onClick={() => onLangChange('en')} className={`text-[10px] font-bold px-3 py-1.5 rounded-full transition-all ${lang === 'en' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600'}`}>EN</button>
                  <button onClick={() => onLangChange('fr')} className={`text-[10px] font-bold px-3 py-1.5 rounded-full transition-all ${lang === 'fr' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600'}`}>FR</button>
                  <button onClick={() => onLangChange('ar')} className={`text-[10px] font-bold px-3 py-1.5 rounded-full transition-all ${lang === 'ar' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600'}`}>AR</button>
                </div>
                <button className="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-md active:scale-95">{content.navClientPortal}</button>
              </div>
            </nav>

            {/* ── Hero ── */}
            <section className="relative pt-24 pb-12 sm:pt-32 px-6 overflow-hidden">
              <div className="max-w-7xl mx-auto flex flex-col items-center text-center">
                <Logo className="h-16 sm:h-24 mb-14" />
                <div className="inline-flex items-center gap-2 bg-slate-50 text-slate-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-10 border border-slate-200">
                  <span className="h-2 w-2 rounded-full bg-teal-500 animate-pulse"></span>
                  {content.heroLabel}
                </div>
                <h1 className="text-5xl sm:text-7xl font-black text-slate-900 tracking-tight leading-none mb-8 max-w-5xl">{content.heroTitle}</h1>
                <p className="text-xl text-slate-500 max-w-2xl mb-14 leading-relaxed font-light">{content.heroSub}</p>
                <div className="flex flex-col sm:flex-row gap-5">
                  <button onClick={() => setShowPopup(true)} className="bg-slate-900 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-800 transition-all flex items-center justify-center gap-2 shadow-2xl shadow-slate-200 group">
                    {content.ctaMain}
                    <ArrowRight size={20} className={`transition-transform ${isRtl ? 'rotate-180 group-hover:-translate-x-1' : 'group-hover:translate-x-1'}`} />
                  </button>
                  <button className="bg-white text-slate-900 border border-slate-200 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-50 transition-all">{content.ctaSub}</button>
                </div>
              </div>
              <div className="absolute inset-0 -z-10 opacity-[0.02]" style={{ backgroundImage: 'radial-gradient(#000 1px, transparent 0)', backgroundSize: '40px 40px' }}></div>
            </section>

            {/* ── Platform Preview ── */}
            <section id="preview" className="py-20 px-6 max-w-7xl mx-auto">
              <div className="text-center mb-10">
                <span className="text-teal-600 font-bold uppercase tracking-widest text-xs">Experience the Standard</span>
                <h2 className="text-3xl font-black text-slate-900 mt-2">Inside the GESCOM Ecosystem</h2>
              </div>
              <PlatformMockup />
            </section>

            {/* ── Features ── */}
            <section id="features" className="py-32 bg-slate-50/50">
              <div className="max-w-6xl mx-auto px-6">
                <div className="text-center mb-24">
                  <h2 className="text-4xl font-bold text-slate-900 mb-6">{content.modulesTitle}</h2>
                  <p className="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">{content.modulesDesc}</p>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-10">
                  {content.features.map((f, i) => (
                    <div key={i} className="bg-white p-12 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 group">
                      <div className="w-16 h-16 bg-slate-900 text-white rounded-2xl flex items-center justify-center mb-8 group-hover:bg-teal-600 transition-colors duration-500">
                        {IconMap[f.icon]}
                      </div>
                      <h3 className="text-2xl font-bold text-slate-900 mb-4">{f.title}</h3>
                      <p className="text-slate-500 leading-relaxed mb-8 text-lg">{f.description}</p>
                      <a href="#" className="inline-flex items-center gap-2 text-teal-600 font-bold text-sm uppercase tracking-[0.2em] group/link">
                        {content.systemDetails}
                        <ChevronRight size={20} className={`transition-transform ${isRtl ? 'rotate-180 group-hover/link:-translate-x-1' : 'group-hover/link:translate-x-1'}`} />
                      </a>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            {/* ── Testimonials ── */}
            <section id="testimonials" className="py-28 bg-white">
              <div className="max-w-6xl mx-auto px-6">
                <div className="text-center mb-20">
                  <h2 className="text-3xl font-bold text-slate-900 mb-2">{content.testimonialsTitle}</h2>
                  <div className="h-1 w-12 bg-teal-500 mx-auto"></div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
                  {content.testimonials.map((t, i) => (
                    <div key={i} className="bg-slate-50 p-10 rounded-3xl border border-slate-100 relative">
                      <Quote className="absolute top-6 right-6 text-slate-200" size={40} />
                      <p className="text-lg text-slate-700 font-medium italic mb-8 relative z-10">"{t.quote}"</p>
                      <div className="flex items-center gap-4">
                        <div className="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center text-white font-bold">{t.author.charAt(0)}</div>
                        <div>
                          <h4 className="font-bold text-slate-900">{t.author}</h4>
                          <p className="text-xs text-slate-400 font-bold uppercase tracking-widest">{t.company}</p>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            {/* ── Footer ── */}
            <footer className="bg-slate-900 text-white pt-32 pb-16 px-6">
              <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-20 mb-20">
                <div className="lg:col-span-2">
                  <Logo variant="inverted" className="h-12 mb-10" />
                  <p className="text-slate-400 max-w-md text-lg leading-relaxed mb-12">{content.heroSub}</p>
                  <div className="flex items-center gap-4 text-teal-500 font-bold uppercase tracking-[0.3em] text-xs">
                    <Globe size={18} />
                    Une solution <strong>DEVELOP IT</strong>
                  </div>
                </div>
                <div>
                  <h4 className="font-bold text-sm uppercase tracking-widest mb-10 text-slate-200">{content.footerCol1Title}</h4>
                  <ul className="space-y-5 text-base text-slate-500">
                    {content.footerFunctions.map((item, idx) => <li key={idx} className="hover:text-white transition-colors cursor-pointer">{item}</li>)}
                  </ul>
                </div>
                <div>
                  <h4 className="font-bold text-sm uppercase tracking-widest mb-10 text-slate-200">{content.footerCol2Title}</h4>
                  <ul className="space-y-5 text-base text-slate-500">
                    {content.footerEnterprise.map((item, idx) => <li key={idx} className="hover:text-white transition-colors cursor-pointer">{item}</li>)}
                  </ul>
                </div>
              </div>
              <div className="max-w-7xl mx-auto pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8 text-[11px] text-slate-500 font-bold uppercase tracking-[0.2em]">
                <p>{content.footerCopyright} • Powered by <span className="text-teal-500">DEVELOP IT</span></p>
                <div className="flex gap-12">
                  {content.footerLinks.map((link, idx) => <a key={idx} href="#" className="hover:text-white transition-colors">{link}</a>)}
                </div>
              </div>
            </footer>
          </div>
        );
      };

      // ── App root ─────────────────────────────────────────────────────
      function App() {
        const [lang, setLang] = useState('fr');
        return (
          <div className="min-h-screen bg-white selection:bg-teal-100 selection:text-teal-900">
            <main className="relative">
              <LandingPage lang={lang} onLangChange={(l) => setLang(l)} />
            </main>
          </div>
        );
      }

      ReactDOM.createRoot(document.getElementById('root')).render(<App />);
      setTimeout(() => { if (window.lucide) lucide.createIcons(); }, 200);

    }, 100);
  </script>
</body>
</html>