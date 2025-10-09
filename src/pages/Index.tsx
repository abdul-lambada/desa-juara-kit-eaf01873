import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { ArrowRight, Users, Building2, TrendingUp, Calendar, MapPin } from "lucide-react";
import { Link } from "react-router-dom";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import heroImage from "@/assets/hero-desa.jpg";
import gallery1 from "@/assets/gallery-1.jpg";
import gallery2 from "@/assets/gallery-2.jpg";
import gallery3 from "@/assets/gallery-3.jpg";

const Index = () => {
  const newsItems = [
    {
      id: 1,
      title: "Pembangunan Jalan Desa Dimulai",
      date: "15 Maret 2024",
      category: "Infrastruktur",
      excerpt: "Pemerintah desa memulai pembangunan jalan baru sepanjang 2 kilometer untuk meningkatkan aksesibilitas warga.",
    },
    {
      id: 2,
      title: "Pelatihan UMKM untuk Warga",
      date: "10 Maret 2024",
      category: "Pemberdayaan",
      excerpt: "Dinas Koperasi dan UMKM mengadakan pelatihan wirausaha bagi warga yang ingin mengembangkan usaha.",
    },
    {
      id: 3,
      title: "Lomba 17 Agustus Meriah",
      date: "5 Maret 2024",
      category: "Acara",
      excerpt: "Panitia HUT RI mengumumkan rangkaian lomba kemerdekaan yang akan digelar di lapangan desa.",
    },
  ];

  const stats = [
    { icon: Users, label: "Jumlah Penduduk", value: "3.245", color: "text-primary" },
    { icon: Building2, label: "Dusun", value: "4", color: "text-secondary" },
    { icon: TrendingUp, label: "UMKM Aktif", value: "127", color: "text-primary" },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Hero Section */}
      <section className="relative h-[600px] flex items-center justify-center overflow-hidden mt-16">
        <div 
          className="absolute inset-0 bg-cover bg-center"
          style={{ backgroundImage: `url(${heroImage})` }}
        >
          <div className="absolute inset-0 bg-gradient-to-r from-primary/90 to-secondary/80"></div>
        </div>
        
        <div className="relative z-10 container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Selamat Datang
          </Badge>
          <h1 className="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
            Desa Maju Sejahtera
          </h1>
          <p className="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-95">
            Website Resmi Desa Maju Sejahtera - Melayani dengan Hati untuk Masyarakat yang Sejahtera
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/profil">
              <Button size="lg" variant="secondary" className="font-semibold">
                Tentang Kami
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
            <Link to="/kontak">
              <Button size="lg" variant="outline" className="bg-primary-foreground/10 border-primary-foreground/30 text-primary-foreground hover:bg-primary-foreground/20 font-semibold">
                Hubungi Kami
              </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="py-12 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {stats.map((stat, index) => (
              <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                <CardContent className="pt-6">
                  <stat.icon className={`w-12 h-12 mx-auto mb-4 ${stat.color}`} />
                  <h3 className="text-3xl font-bold text-foreground mb-2">{stat.value}</h3>
                  <p className="text-muted-foreground">{stat.label}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* About Section */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div className="animate-fade-in">
              <Badge className="mb-4">Tentang Kami</Badge>
              <h2 className="text-3xl md:text-4xl font-bold mb-6 text-foreground">
                Desa yang Maju dan Sejahtera
              </h2>
              <p className="text-muted-foreground text-lg mb-6 leading-relaxed">
                Desa Maju Sejahtera adalah desa yang terletak di kawasan strategis dengan 
                potensi pertanian dan UMKM yang berkembang pesat. Kami berkomitmen untuk 
                memberikan pelayanan terbaik kepada masyarakat melalui inovasi dan teknologi digital.
              </p>
              <div className="space-y-3 mb-6">
                <div className="flex items-start space-x-3">
                  <MapPin className="w-5 h-5 text-primary mt-1 flex-shrink-0" />
                  <p className="text-muted-foreground">
                    Jl. Raya Desa No. 123, Kec. Maju, Kab. Sejahtera
                  </p>
                </div>
              </div>
              <Link to="/profil">
                <Button className="font-semibold">
                  Selengkapnya
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </Link>
            </div>
            <div className="grid grid-cols-2 gap-4">
              <img 
                src={gallery2} 
                alt="Aktivitas Desa" 
                className="rounded-lg shadow-lg hover:shadow-xl transition-shadow"
              />
              <img 
                src={gallery1} 
                alt="Masyarakat Desa" 
                className="rounded-lg shadow-lg hover:shadow-xl transition-shadow mt-8"
              />
            </div>
          </div>
        </div>
      </section>

      {/* News Section */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <Badge className="mb-4">Berita Terkini</Badge>
            <h2 className="text-3xl md:text-4xl font-bold text-foreground">
              Berita & Pengumuman Desa
            </h2>
          </div>
          
          <div className="grid md:grid-cols-3 gap-6">
            {newsItems.map((news) => (
              <Card key={news.id} className="hover:shadow-lg transition-shadow group">
                <CardHeader>
                  <div className="flex items-center justify-between mb-2">
                    <Badge variant="secondary">{news.category}</Badge>
                    <div className="flex items-center text-sm text-muted-foreground">
                      <Calendar className="w-4 h-4 mr-1" />
                      {news.date}
                    </div>
                  </div>
                  <CardTitle className="group-hover:text-primary transition-colors">
                    {news.title}
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription className="mb-4">{news.excerpt}</CardDescription>
                  <Link to="/berita">
                    <Button variant="ghost" size="sm" className="p-0 h-auto font-semibold">
                      Baca Selengkapnya
                      <ArrowRight className="ml-2 h-4 w-4" />
                    </Button>
                  </Link>
                </CardContent>
              </Card>
            ))}
          </div>

          <div className="text-center mt-8">
            <Link to="/berita">
              <Button variant="outline" size="lg" className="font-semibold">
                Lihat Semua Berita
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* Gallery Preview */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <Badge className="mb-4">Galeri Foto</Badge>
            <h2 className="text-3xl md:text-4xl font-bold text-foreground">
              Kegiatan Desa
            </h2>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="relative overflow-hidden rounded-lg group cursor-pointer">
              <img 
                src={gallery1} 
                alt="Kegiatan 1" 
                className="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                <p className="text-primary-foreground font-semibold">Musyawarah Desa</p>
              </div>
            </div>
            <div className="relative overflow-hidden rounded-lg group cursor-pointer">
              <img 
                src={gallery2} 
                alt="Kegiatan 2" 
                className="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                <p className="text-primary-foreground font-semibold">Gotong Royong</p>
              </div>
            </div>
            <div className="relative overflow-hidden rounded-lg group cursor-pointer">
              <img 
                src={gallery3} 
                alt="Kegiatan 3" 
                className="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                <p className="text-primary-foreground font-semibold">Perayaan Tradisional</p>
              </div>
            </div>
          </div>

          <div className="text-center mt-8">
            <Link to="/galeri">
              <Button variant="outline" size="lg" className="font-semibold">
                Lihat Galeri Lengkap
                <ArrowRight className="ml-2 h-5 w-5" />
              </Button>
            </Link>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Index;
