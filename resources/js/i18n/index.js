import { createI18n } from 'vue-i18n'

const messages = {
  id: {
    nav: {
      home: 'Beranda',
      about: 'Tentang Kami',
      programs: 'Program',
      kmi: 'KMI (Pondok Modern)',
      smp: 'SMP Al-Hikmah',
      ma: 'MA Al-Hikmah',
      facilities: 'Fasilitas',
      activities: 'Aktivitas',
      gallery: 'Galeri',
      elearning: 'E-Learning', 
      login: 'Masuk',
      news: 'Berita',
      agenda: 'Agenda Santri',
      register: 'Daftar Sekarang'
    },
    hero: {
      text1: 'Memadukan',
      text2: 'Tradisi',
      text3: 'Klasik',
      text4: 'dengan Inovasi',
      text5: 'Modern',
      subtitle: 'Dengan menjunjung tinggi silsilah keilmuan para pendahulu yang otoritatif, kami mengembangkan metode pembelajaran kreatif untuk memastikan santri tetap mampu menjawab kebutuhan dunia yang terus berkembang tanpa kehilangan identitas sebagai Muslim.',
      cta_register: 'Daftar Sekarang',
      cta_explore: 'Pelajari Kurikulum Kami'
    },
    why: {
      title: 'Mengapa Memilih Kami?',
      subtitle: 'Komitmen kami untuk memberikan pendidikan terbaik bagi masa depan putra-putri Anda.',
      items: [
        { title: 'Kurikulum Terpadu', desc: 'Perpaduan harmonis antara kurikulum nasional dan kurikulum pesantren modern.' },
        { title: 'Hafalan Al-Quran', desc: 'Program tahfidz 30 juz dengan metode mutqin dan bimbingan ustadz berpengalaman.' },
        { title: 'Fasilitas Modern', desc: 'Gedung asrama, laboratorium, perpustakaan, dan masjid yang nyaman dan memadai.' },
        { title: 'Tenaga Ahli', desc: 'Dididik oleh para pengajar lulusan universitas ternama dan pondok pesantren terkemuka.' },
        { title: 'Lingkungan Islami', desc: 'Suasana belajar yang kondusif untuk pembentukan karakter dan akhlakul karimah.' },
        { title: 'Prestasi Gemilang', desc: 'Mencetak santri berprestasi di tingkat nasional baik akademik maupun keagamaan.' }
      ]
    },
    testimonial: {
      title: 'Apa Kata Mereka?',
      subtitle: 'Testimoni jujur dari wali santri, alumni, dan santri aktif tentang pengalaman mereka bersama Al-Hikmah.',
      roles: ['Wali Santri', 'Alumni 2022', 'Santri Aktif Kelas 11'],
      texts: [
        'Alhamdulillah, sejak mondok di Al-Hikmah, putra kami menjadi lebih disiplin, mandiri, dan hafalannya terus bertambah. Kurikulum teknologinya juga sangat membantu.',
        'Pengalaman 6 tahun di Al-Hikmah adalah masa paling berharga. Bekal agama dan bahasa yang kuat membantu saya beradaptasi dengan baik di perguruan tinggi.',
        'Suasana belajarnya seru banget! Ustadznya asik dan fasilitasnya lengkap. Saya betah banget tinggal di asrama dan belajar banyak hal baru setiap hari.'
      ]
    },
    about: {
      title: 'Tentang Al-Hikmah',
      subtitle: 'Mengenal lebih dekat perjalanan dan dedikasi kami dalam dunia pendidikan Islam.',
      p1: 'Pondok Modern Al-Hikmah didirikan dan diasuh oleh <strong>KH. Syihabuddin Muhammad</strong> (Alumni Pondok Modern Darussalam Gontor) pada tanggal 27 Juli 2006 di Dusun Koda Permai Kec. Utan Kab. Sumbawa NTB atas dasar panggilan Dakwah Islamiyah dan pada tahun 2012 Hijrah Lokasi ke Dusun Bina Marga Desa Stowe Brang Kec. Utan Kab. Sumbawa.',
      p2: 'Program pendidikan dan pengajarannya diorientasikan untuk mempersiapkan kader-kader Islam yang siap berjuang di segala aspek kehidupan dengan mengintegrasikan PQ (Physic Quotient), SQ (Spiritual Quotient), IQ (Intelligent Quotient), dan EQ (Emotional Quotient) dalam menanamkan pilar kemantapan akidah, kedalaman spiritual, akhlakul karimah, keluasan IPTEK serta kematangan hidup.',
      founder_title: 'Pendiri & Pimpinan Pondok'
    },
    vision: {
      title: 'Visi, Misi & Motto',
      subtitle: 'Fondasi kuat yang menjadi kompas dalam setiap langkah kami mencetak generasi unggul.',
      more: 'Selengkapnya',
      close: 'Tutup',
      items: [
        { title: 'Visi Kami', short: 'Menjadi Lembaga Pendidikan Islam yang mencetak kader-kader Pemimpin Ummat berlandaskan Al-Quran dan Sunnah.', detail: 'Sebagai Lembaga Pendidikan Islam yang mencetak kader-kader Pemimpin Ummat, menjadi tempat ibadah dan sumber ilmu pengetahuan agama dan umum dengan tetap berjiwa Pesantren.' },
        { title: 'Misi Kami', short: 'Membentuk generasi mu’min muslim yang berbudi tinggi, berbadan sehat, dan berpengetahuan luas.', detail: [
          'Mempersiapkan generasi yang unggul dan berkualitas yang berpegang teguh kepada Al-Quran dan Sunnah serta Ulama’ Ahlu Sunnah wal Jama’ah.',
          'Mendidik dan membentuk generasi mu’min muslim yang berbudi tinggi, berbadan sehat, berpengetahuan luas dan berfikiran bebas serta berkhidmat kepada masyarakat.',
          'Mengajarkan ilmu pengetahuan agama dan umum secara integral menuju terbentuknya ulama yang intelek.',
          'Mempersiapkan warga Negara yang beriman, bertakwa, berakhlaqul karimah, berilmu, beramal sholeh, terampil, cinta agama dan tanah air.'
        ] },
        { title: 'Motto Kami', short: 'Empat pilar karakter santri: Berbudi Tinggi, Berbadan Sehat, Berpengetahuan Luas, dan Berpikiran Bebas.', detail: 'Berbudi Tinggi, Berbadan Sehat, Berpengetahuan Luas, dan Berpikiran Bebas' },
        { title: 'Panca Jiwa', short: 'Lima nilai dasar jiwa pesantren: Keikhlasan, Kesederhanaan, Berdikari, Ukhuwah, dan Kebebasan.', detail: [
          'Keikhlasan', 'Kesederhanaan', 'Berdikari (Kemandirian)', 'Ukhuwah Islamiyah', 'Kebebasan'
        ] }
      ]
    },
    programs: {
      title: 'Program Unggulan',
      subtitle: 'Kurikulum terintegrasi yang dirancang untuk mengasah potensi intelektual dan spiritual santri.',
      more: 'Selengkapnya',
      tabs: { all: 'Semua', extra: 'Ekstrakurikuler', class: 'Kelas V & VI' },
      items: [
        { title: 'Tahfidzul Qur’an', desc: 'Program menghafal Al-Qur’an dengan metode tajwid dan murajaah yang intensif.' },
        { title: 'Pidato 3 Bahasa', desc: 'Latihan muhadharah dalam Bahasa Indonesia, Arab, dan Inggris untuk mengasah orasi.' },
        { title: 'Kesenian Islam', desc: 'Seni Hadroh, Tari, Puisi, Drama Teater, Kaligrafi, Lukis, hingga Karikatur.' },
        { title: 'Keterampilan (Skill)', desc: 'Broadcasting, MC, Tata Boga, Menjahit, Jurnalistik, hingga Desain Komunikasi Visual (DKV).' },
        { title: 'Olahraga & Atletik', desc: 'Basket, Sepak Bola, Takraw, Voli, Tenis Meja, Badminton, dan Bela Diri Tapak Suci.' },
        { title: 'Kajian Kitab Turats', desc: 'Pendalaman literatur klasik Islam (Kitab Kuning) untuk pemahaman agama yang mendalam.' },
        { title: 'Pramuka & Drum Band', desc: 'Pembentukan disiplin, kepemimpinan, dan kerjasama tim melalui kepanduan dan musik.' },
        { title: 'Organisasi (OPPH)', desc: 'Praktik kepemimpinan langsung melalui Organisasi Pelajar Pondok Modern Al-Hikmah.' },
        { title: 'Ta’hilud Durus', desc: 'Pendalaman materi pelajaran KMI dari kelas I hingga VI sebagai persiapan ujian akhir.' },
        { title: 'Amaliyatu Tadris', desc: 'Praktik mengajar (Teaching Practice) bagi santri kelas akhir untuk melatih kemandirian.' },
        { title: 'Fathul Kutub', desc: 'Kajian kritis kitab klasik dan Bahtsul Masa’il untuk menjawab tantangan zaman.' },
        { title: 'Studi Tour & Workshop', desc: 'Kunjungan ilmiah, kewirausahaan, seminar, dan penulisan Karya Ilmiah (KTI).' },
        { title: 'Pelatihan Imamah', desc: 'Pembekalan imamah, khitobah, dan dakwah untuk pengabdian di masyarakat.' }
      ]
    },
    facilities: {
      title: 'Fasilitas Modern',
      subtitle: 'Lingkungan belajar dan tempat tinggal yang nyaman untuk menunjang aktivitas harian santri.',
      items: ['Masjid Jami\'', 'Asrama Putra', 'Asrama Putri', 'Laboratorium', 'Perpustakaan', 'Lapangan Olahraga', 'Ruang Makan', 'Gedung Kesenian']
    },
    gallery: {
      title: 'Galeri Aktivitas',
      subtitle: 'Momen-momen berharga dan keceriaan santri dalam menuntut ilmu dan mengukir prestasi.',
      explore: 'Jelajahi Semua Galeri',
      categories: { all: 'Semua', act: 'Kegiatan', ach: 'Prestasi', grad: 'Wisuda', fac: 'Fasilitas' }
    },
    news: {
      title: 'Berita',
      subtitle: 'Ikuti perkembangan terbaru, prestasi santri, dan jadwal kegiatan penting di lingkungan pesantren.',
      read_more: 'Baca Selengkapnya',
      load_more: 'Muat Lebih Banyak Berita',
      categories: { all: 'Semua', act: 'Aktivitas', ach: 'Prestasi', info: 'Informasi' }
    },
    cta: {
      title: 'Siap Bergabung Bersama',
      title_hl: 'Al-Hikmah?',
      subtitle: 'Pendaftaran santri baru tahun ajaran 2026/2027 telah dibuka. Amankan kursi untuk putra-putri Anda sekarang juga dan jadilah bagian dari keluarga besar kami.',
      register: 'Daftar Sekarang',
      contact: 'Hubungi Kami',
      scholarship: 'Info Beasiswa',
      tags: ['Kuota Terbatas', 'Pendaftaran Online', 'Beasiswa Prestasi']
    }
  },
  en: {
    nav: {
      home: 'Home',
      about: 'About Us',
      programs: 'Programs',
      kmi: 'KMI (Modern Boarding)',
      smp: 'SMP Al-Hikmah',
      ma: 'MA Al-Hikmah',
      facilities: 'Facilities',
      activities: 'Activities',
      gallery: 'Gallery',
      elearning: 'E-Learning',
      login: 'Login',
      news: 'News & Events',
      agenda: 'Student Agenda',
      register: 'Register Now'
    },
    hero: {
      text1: 'Bridging',
      text2: 'Timeless',
      text3: 'Tradition',
      text4: 'and Modern',
      text5: 'Innovation',
      subtitle: 'By upholding the authoritative scholarly lineage of our predecessors, we develop creative learning methods to ensure students remain capable of meeting the needs of an evolving world without losing their identity as Muslims.',
      cta_register: 'Register Now',
      cta_explore: 'Explore Our Curriculum'
    },
    why: {
      title: 'Why Choose Us?',
      subtitle: 'Our commitment to providing the best education for your children\'s future.',
      items: [
        { title: 'Integrated Curriculum', desc: 'A harmonious blend of the national curriculum and modern Islamic boarding school curriculum.' },
        { title: 'Quran Memorization', desc: 'A 30-juz memorization program with mutqin methods and experienced tutors.' },
        { title: 'Modern Facilities', desc: 'Comfortable and adequate dormitories, laboratories, library, and mosque.' },
        { title: 'Expert Teachers', desc: 'Educated by graduates of top universities and leading Islamic boarding schools.' },
        { title: 'Islamic Environment', desc: 'A conducive learning atmosphere for character building and noble morals.' },
        { title: 'Outstanding Achievements', desc: 'Producing students with national-level achievements in academics and religion.' }
      ]
    },
    testimonial: {
      title: 'What They Say?',
      subtitle: 'Honest testimonials from parents, alumni, and active students about their experience with Al-Hikmah.',
      roles: ['Parent', 'Alumnus 2022', '11th Grade Student'],
      texts: [
        'Alhamdulillah, since joining Al-Hikmah, our son has become more disciplined, independent, and his memorization keeps improving. The technology curriculum also helps a lot.',
        'My 6 years at Al-Hikmah were the most valuable time. The strong religious and language foundation helped me adapt well in university.',
        'The learning atmosphere is amazing! The teachers are fun and facilities are complete. I really enjoy living in the dorms and learning new things every day.'
      ]
    },
    about: {
      title: 'About Al-Hikmah',
      subtitle: 'Get to know our journey and dedication in the world of Islamic education.',
      p1: 'Modern Islamic Boarding School Al-Hikmah was founded and nurtured by <strong>KH. Syihabuddin Muhammad</strong> (Alumnus of Gontor Modern Boarding School) on July 27, 2006, in Koda Permai, Utan, Sumbawa. Based on the calling of Islamic Da\'wah, it relocated in 2012 to Bina Marga, Stowe Brang Village, Utan, Sumbawa.',
      p2: 'Its educational programs are oriented towards preparing Islamic cadres ready to strive in all aspects of life by integrating PQ (Physical Quotient), SQ (Spiritual Quotient), IQ (Intelligent Quotient), and EQ (Emotional Quotient) to instill strong faith, deep spirituality, noble character, broad knowledge, and maturity.',
      founder_title: 'Founder & Director'
    },
    vision: {
      title: 'Vision, Mission & Motto',
      subtitle: 'The strong foundation that acts as a compass in our journey to build an excellent generation.',
      more: 'Read More',
      close: 'Close',
      items: [
        { title: 'Our Vision', short: 'To become an Islamic Educational Institution that produces Muslim leaders based on the Quran and Sunnah.', detail: 'As an Islamic Educational Institution that produces Ummah Leaders, serving as a place of worship and a source of religious and general knowledge while maintaining the soul of a Pesantren.' },
        { title: 'Our Mission', short: 'To form a generation of believers who are noble in character, physically healthy, and broadly knowledgeable.', detail: [
          'Preparing an excellent and high-quality generation holding firmly to the Quran, Sunnah, and Ahlu Sunnah wal Jama\'ah scholars.',
          'Educating and forming a generation of believers who are noble, healthy, knowledgeable, free-thinking, and dedicated to society.',
          'Teaching religious and general sciences integrally towards forming intellectual scholars.',
          'Preparing citizens who are faithful, pious, noble, knowledgeable, righteous, skilled, and love their religion and country.'
        ] },
        { title: 'Our Motto', short: 'Four pillars of student character: Noble Character, Healthy Body, Broad Knowledge, and Free Thinking.', detail: 'Noble Character, Healthy Body, Broad Knowledge, and Free Thinking' },
        { title: 'Five Souls', short: 'Five core values of the pesantren soul: Sincerity, Simplicity, Independence, Brotherhood, and Freedom.', detail: [
          'Sincerity', 'Simplicity', 'Independence', 'Islamic Brotherhood', 'Freedom'
        ] }
      ]
    },
    programs: {
      title: 'Featured Programs',
      subtitle: 'An integrated curriculum designed to sharpen students\' intellectual and spiritual potential.',
      more: 'Read More',
      tabs: { all: 'All', extra: 'Extracurricular', class: 'Class V & VI' },
      items: [
        { title: 'Quranic Memorization', desc: 'An intensive Quran memorization program using tajweed and murajaah methods.' },
        { title: '3-Language Speech', desc: 'Public speaking practice in Indonesian, Arabic, and English to hone oratorical skills.' },
        { title: 'Islamic Arts', desc: 'Hadroh, Dance, Poetry, Theater, Calligraphy, Painting, and Caricature.' },
        { title: 'Life Skills', desc: 'Broadcasting, MC, Culinary, Sewing, Journalism, and Visual Communication Design.' },
        { title: 'Sports & Athletics', desc: 'Basketball, Football, Sepak Takraw, Volleyball, Table Tennis, Badminton, and Martial Arts.' },
        { title: 'Classical Texts Study', desc: 'In-depth study of classical Islamic literature (Yellow Books) for profound religious understanding.' },
        { title: 'Scout & Drum Band', desc: 'Building discipline, leadership, and teamwork through scouting and music.' },
        { title: 'Student Organization', desc: 'Direct leadership practice through the Modern Boarding School Student Organization.' },
        { title: 'Ta’hilud Durus', desc: 'Deepening KMI lesson materials from class I to VI in preparation for final exams.' },
        { title: 'Teaching Practice', desc: 'Practical teaching experience for final-year students to train independence.' },
        { title: 'Fathul Kutub', desc: 'Critical study of classical texts and Bahtsul Masa\'il to answer modern challenges.' },
        { title: 'Study Tour & Workshop', desc: 'Scientific visits, entrepreneurship, seminars, and scientific writing.' },
        { title: 'Imamah Training', desc: 'Equipping students with imamah, khitobah, and da\'wah skills for community service.' }
      ]
    },
    facilities: {
      title: 'Modern Facilities',
      subtitle: 'A comfortable learning and living environment to support students\' daily activities.',
      items: ['Grand Mosque', 'Boys Dormitory', 'Girls Dormitory', 'Laboratory', 'Library', 'Sports Field', 'Dining Hall', 'Art Center']
    },
    gallery: {
      title: 'Activity Gallery',
      subtitle: 'Precious moments and the joy of our students in seeking knowledge and achieving success.',
      explore: 'Explore All Gallery',
      categories: { all: 'All', act: 'Activities', ach: 'Achievements', grad: 'Graduation', fac: 'Facilities' }
    },
    news: {
      title: 'News & Events',
      subtitle: 'Follow the latest updates, student achievements, and important event schedules in our pesantren.',
      read_more: 'Read More',
      load_more: 'Load More News',
      categories: { all: 'All', act: 'Activities', ach: 'Achievements', info: 'Information' }
    },
    cta: {
      title: 'Ready to Join',
      title_hl: 'Al-Hikmah?',
      subtitle: 'Registration for new students for the 2026/2027 academic year is now open. Secure a seat for your child today and become part of our big family.',
      register: 'Register Now',
      contact: 'Contact Us',
      scholarship: 'Scholarship Info',
      tags: ['Limited Seats', 'Online Registration', 'Achievement Scholarships']
    }
  }
}

const i18n = createI18n({
  legacy: false, // Use Composition API
  locale: 'id', // Default language
  fallbackLocale: 'en',
  messages
})

export default i18n
