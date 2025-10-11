import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { ShoppingBag, Phone, MapPin } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Produk = () => {
  const produkUMKM = [
    {
      id: 1,
      nama: "Keripik Singkong Renyah",
      kategori: "Makanan",
      harga: "Rp 15.000",
      penjual: "Ibu Siti Aminah",
      kontak: "0812-3456-7890",
      lokasi: "Dusun 1",
      deskripsi: "Keripik singkong dengan berbagai rasa: original, balado, keju",
    },
    {
      id: 2,
      nama: "Batik Tulis Motif Lokal",
      kategori: "Kerajinan",
      harga: "Rp 250.000",
      penjual: "Bapak Suharto",
      kontak: "0813-4567-8901",
      lokasi: "Dusun 2",
      deskripsi: "Batik tulis dengan motif khas desa, bahan berkualitas",
    },
    {
      id: 3,
      nama: "Madu Hutan Asli",
      kategori: "Makanan",
      harga: "Rp 75.000",
      penjual: "Kelompok Tani Maju",
      kontak: "0814-5678-9012",
      lokasi: "Dusun 3",
      deskripsi: "Madu murni dari hutan lindung, tanpa campuran",
    },
    {
      id: 4,
      nama: "Anyaman Bambu",
      kategori: "Kerajinan",
      harga: "Rp 50.000",
      penjual: "Ibu Kartini",
      kontak: "0815-6789-0123",
      lokasi: "Dusun 1",
      deskripsi: "Berbagai produk anyaman: tas, tempat buah, hiasan dinding",
    },
    {
      id: 5,
      nama: "Kopi Robusta Premium",
      kategori: "Minuman",
      harga: "Rp 45.000",
      penjual: "Kelompok Tani Sejahtera",
      kontak: "0816-7890-1234",
      lokasi: "Dusun 4",
      deskripsi: "Kopi robusta pilihan dari kebun sendiri, dipanggang fresh",
    },
    {
      id: 6,
      nama: "Jamu Tradisional",
      kategori: "Minuman",
      harga: "Rp 10.000",
      penjual: "Ibu Dewi Sartika",
      kontak: "0817-8901-2345",
      lokasi: "Dusun 2",
      deskripsi: "Jamu tradisional: kunyit asam, beras kencur, temulawak",
    },
    {
      id: 7,
      nama: "Kerajinan Tanah Liat",
      kategori: "Kerajinan",
      harga: "Rp 35.000",
      penjual: "Bapak Ahmad Yani",
      kontak: "0818-9012-3456",
      lokasi: "Dusun 3",
      deskripsi: "Pot, vas bunga, dan dekorasi dari tanah liat",
    },
    {
      id: 8,
      nama: "Dodol Durian",
      kategori: "Makanan",
      harga: "Rp 25.000",
      penjual: "Ibu Sri Wahyuni",
      kontak: "0819-0123-4567",
      lokasi: "Dusun 1",
      deskripsi: "Dodol durian asli dengan rasa yang legit dan manis",
    },
    {
      id: 9,
      nama: "Tas Eceng Gondok",
      kategori: "Kerajinan",
      harga: "Rp 125.000",
      penjual: "Kelompok Wanita Kreatif",
      kontak: "0820-1234-5678",
      lokasi: "Dusun 4",
      deskripsi: "Tas ramah lingkungan dari eceng gondok berkualitas",
    },
  ];

  const categories = ["Semua", "Makanan", "Minuman", "Kerajinan"];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            UMKM Desa
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Produk Unggulan Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Dukung UMKM lokal dengan membeli produk-produk berkualitas dari masyarakat desa
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
                <ShoppingBag className="w-4 h-4 mr-2" />
                {category}
              </Button>
            ))}
          </div>
        </div>
      </section>

      {/* Products Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {produkUMKM.map((produk) => (
              <Card key={produk.id} className="hover:shadow-lg transition-shadow group">
                <CardHeader>
                  <div className="flex items-start justify-between mb-2">
                    <Badge variant="secondary">{produk.kategori}</Badge>
                    <p className="text-xl font-bold text-primary">{produk.harga}</p>
                  </div>
                  <CardTitle className="text-xl group-hover:text-primary transition-colors">
                    {produk.nama}
                  </CardTitle>
                  <CardDescription className="line-clamp-2">{produk.deskripsi}</CardDescription>
                </CardHeader>
                <CardContent className="space-y-3">
                  <div className="space-y-2 text-sm">
                    <div className="flex items-start">
                      <span className="font-semibold text-foreground min-w-20">Penjual:</span>
                      <span className="text-muted-foreground">{produk.penjual}</span>
                    </div>
                    <div className="flex items-start">
                      <MapPin className="w-4 h-4 mr-2 text-primary flex-shrink-0 mt-0.5" />
                      <span className="text-muted-foreground">{produk.lokasi}</span>
                    </div>
                    <div className="flex items-start">
                      <Phone className="w-4 h-4 mr-2 text-primary flex-shrink-0 mt-0.5" />
                      <a 
                        href={`tel:${produk.kontak}`}
                        className="text-primary hover:underline"
                      >
                        {produk.kontak}
                      </a>
                    </div>
                  </div>
                  <Button className="w-full font-semibold" size="sm">
                    <Phone className="w-4 h-4 mr-2" />
                    Hubungi Penjual
                  </Button>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <Card className="bg-gradient-hero text-primary-foreground">
            <CardContent className="p-8 md:p-12 text-center">
              <h2 className="text-3xl font-bold mb-4">
                Punya Produk UMKM?
              </h2>
              <p className="text-lg opacity-90 mb-6 max-w-2xl mx-auto">
                Daftarkan produk UMKM Anda agar dapat dipromosikan melalui website desa
              </p>
              <Button size="lg" variant="secondary" className="font-semibold">
                Daftar Produk
              </Button>
            </CardContent>
          </Card>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Produk;
