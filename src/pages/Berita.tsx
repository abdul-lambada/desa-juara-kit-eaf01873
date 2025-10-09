import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Calendar, ArrowRight } from "lucide-react";
import { Button } from "@/components/ui/button";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Berita = () => {
  const allNews = [
    {
      id: 1,
      title: "Pembangunan Jalan Desa Dimulai",
      date: "15 Maret 2024",
      category: "Infrastruktur",
      excerpt: "Pemerintah desa memulai pembangunan jalan baru sepanjang 2 kilometer untuk meningkatkan aksesibilitas warga.",
      content: "Pembangunan jalan ini merupakan bagian dari program prioritas desa tahun 2024. Dengan total anggaran Rp 500 juta, jalan ini akan menghubungkan area persawahan dengan pusat desa.",
    },
    {
      id: 2,
      title: "Pelatihan UMKM untuk Warga",
      date: "10 Maret 2024",
      category: "Pemberdayaan",
      excerpt: "Dinas Koperasi dan UMKM mengadakan pelatihan wirausaha bagi warga yang ingin mengembangkan usaha.",
      content: "Pelatihan ini diikuti oleh 50 peserta dari berbagai dusun. Materi yang diberikan meliputi manajemen usaha, pemasaran digital, dan akses permodalan.",
    },
    {
      id: 3,
      title: "Lomba 17 Agustus Meriah",
      date: "5 Maret 2024",
      category: "Acara",
      excerpt: "Panitia HUT RI mengumumkan rangkaian lomba kemerdekaan yang akan digelar di lapangan desa.",
      content: "Lomba akan diikuti oleh seluruh warga dari 4 dusun. Hadiah total mencapai Rp 10 juta dengan berbagai kategori lomba tradisional.",
    },
    {
      id: 4,
      title: "Posyandu Lansia Dibuka",
      date: "1 Maret 2024",
      category: "Kesehatan",
      excerpt: "Puskesmas bekerja sama dengan desa membuka layanan posyandu khusus lansia setiap minggu.",
      content: "Posyandu lansia akan melayani pemeriksaan kesehatan rutin, senam lansia, dan edukasi kesehatan setiap hari Kamis pukul 08.00 WIB.",
    },
    {
      id: 5,
      title: "Bantuan Benih Padi untuk Petani",
      date: "25 Februari 2024",
      category: "Pertanian",
      excerpt: "Dinas Pertanian memberikan bantuan benih padi unggul kepada 100 petani di desa.",
      content: "Program ini bertujuan meningkatkan produktivitas padi dengan varietas unggul yang tahan hama dan memiliki hasil panen lebih baik.",
    },
    {
      id: 6,
      title: "Perpustakaan Desa Direnovasi",
      date: "20 Februari 2024",
      category: "Pendidikan",
      excerpt: "Perpustakaan desa mendapat bantuan renovasi dan penambahan koleksi buku dari provinsi.",
      content: "Renovasi meliputi perbaikan ruang baca, penambahan rak buku, dan pembelian 500 buku baru berbagai genre untuk semua usia.",
    },
    {
      id: 7,
      title: "Festival Budaya Desa 2024",
      date: "15 Februari 2024",
      category: "Budaya",
      excerpt: "Desa akan menggelar festival budaya tahunan dengan menampilkan seni dan budaya lokal.",
      content: "Festival akan menampilkan pertunjukan tari tradisional, musik gamelan, pameran kerajinan tangan, dan kuliner khas desa.",
    },
    {
      id: 8,
      title: "Program Bantuan Bedah Rumah",
      date: "10 Februari 2024",
      category: "Sosial",
      excerpt: "Pemerintah desa meluncurkan program bedah rumah untuk 10 rumah warga kurang mampu.",
      content: "Program ini merupakan hasil kerja sama dengan CSR perusahaan dan swadaya masyarakat untuk meningkatkan kualitas hunian warga.",
    },
    {
      id: 9,
      title: "Pasar Desa Dibuka Setiap Minggu",
      date: "5 Februari 2024",
      category: "Ekonomi",
      excerpt: "Pemerintah desa membuka pasar mingguan untuk memberdayakan UMKM lokal.",
      content: "Pasar desa akan dibuka setiap hari Minggu pukul 06.00-12.00 WIB di lapangan desa dengan 50 stand pedagang lokal.",
    },
  ];

  const categories = ["Semua", "Infrastruktur", "Pemberdayaan", "Acara", "Kesehatan", "Pertanian", "Pendidikan", "Budaya", "Sosial", "Ekonomi"];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Informasi Terkini
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Berita & Pengumuman
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Informasi terbaru seputar kegiatan dan program Desa Maju Sejahtera
          </p>
        </div>
      </section>

      {/* Filter Categories */}
      <section className="py-8 border-b border-border">
        <div className="container mx-auto px-4">
          <div className="flex flex-wrap gap-2 justify-center">
            {categories.map((category) => (
              <Button
                key={category}
                variant={category === "Semua" ? "default" : "outline"}
                size="sm"
                className="font-medium"
              >
                {category}
              </Button>
            ))}
          </div>
        </div>
      </section>

      {/* News Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {allNews.map((news) => (
              <Card key={news.id} className="hover:shadow-lg transition-shadow group flex flex-col">
                <CardHeader className="flex-grow">
                  <div className="flex items-center justify-between mb-3">
                    <Badge variant="secondary" className="font-medium">{news.category}</Badge>
                    <div className="flex items-center text-sm text-muted-foreground">
                      <Calendar className="w-4 h-4 mr-1" />
                      {news.date}
                    </div>
                  </div>
                  <CardTitle className="group-hover:text-primary transition-colors text-xl">
                    {news.title}
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription className="mb-4 line-clamp-3">{news.excerpt}</CardDescription>
                  <p className="text-sm text-muted-foreground mb-4">{news.content}</p>
                  <Button variant="ghost" size="sm" className="p-0 h-auto font-semibold">
                    Baca Selengkapnya
                    <ArrowRight className="ml-2 h-4 w-4" />
                  </Button>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Berita;
