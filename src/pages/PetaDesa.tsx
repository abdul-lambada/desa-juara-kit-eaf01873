import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { MapPin, TreePine, Sprout, Factory, School, Building2 } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const PetaDesa = () => {
  const wilayahData = [
    { dusun: "Dusun 1", luas: "2.5 km²", rt: 8, rw: 3, kepalaKeluarga: 645 },
    { dusun: "Dusun 2", luas: "3.2 km²", rt: 10, rw: 4, kepalaKeluarga: 734 },
    { dusun: "Dusun 3", luas: "2.8 km²", rt: 9, rw: 3, kepalaKeluarga: 612 },
    { dusun: "Dusun 4", luas: "2.1 km²", rt: 7, rw: 2, kepalaKeluarga: 534 },
  ];

  const potensiData = [
    {
      kategori: "Pertanian",
      icon: Sprout,
      color: "text-green-600",
      items: [
        { nama: "Sawah Produktif", luas: "125 Ha", lokasi: "Dusun 1, 2, 3" },
        { nama: "Kebun Kopi", luas: "45 Ha", lokasi: "Dusun 3, 4" },
        { nama: "Perkebunan Teh", luas: "32 Ha", lokasi: "Dusun 4" },
      ]
    },
    {
      kategori: "Kehutanan",
      icon: TreePine,
      color: "text-emerald-600",
      items: [
        { nama: "Hutan Lindung", luas: "78 Ha", lokasi: "Perbatasan Utara" },
        { nama: "Hutan Produksi", luas: "56 Ha", lokasi: "Dusun 4" },
      ]
    },
    {
      kategori: "Industri & UMKM",
      icon: Factory,
      color: "text-orange-600",
      items: [
        { nama: "Sentra Kerajinan", jumlah: "23 Unit", lokasi: "Dusun 1, 2" },
        { nama: "Industri Makanan", jumlah: "15 Unit", lokasi: "Semua Dusun" },
        { nama: "Toko & Warung", jumlah: "67 Unit", lokasi: "Semua Dusun" },
      ]
    },
    {
      kategori: "Infrastruktur",
      icon: Building2,
      color: "text-blue-600",
      items: [
        { nama: "Kantor Desa", jumlah: "1 Unit", lokasi: "Pusat Desa" },
        { nama: "Balai Desa", jumlah: "4 Unit", lokasi: "Tiap Dusun" },
        { nama: "Posyandu", jumlah: "6 Unit", lokasi: "Semua Dusun" },
        { nama: "Puskesmas Pembantu", jumlah: "1 Unit", lokasi: "Dusun 2" },
      ]
    },
    {
      kategori: "Pendidikan",
      icon: School,
      color: "text-purple-600",
      items: [
        { nama: "TK/PAUD", jumlah: "5 Unit", lokasi: "Semua Dusun" },
        { nama: "SD/MI", jumlah: "4 Unit", lokasi: "Tiap Dusun" },
        { nama: "SMP/MTs", jumlah: "2 Unit", lokasi: "Dusun 1, 3" },
        { nama: "SMA/MA", jumlah: "1 Unit", lokasi: "Dusun 2" },
      ]
    },
  ];

  const batasWilayah = [
    { arah: "Utara", berbatasan: "Desa Maju Jaya" },
    { arah: "Selatan", berbatasan: "Desa Sejahtera" },
    { arah: "Timur", berbatasan: "Desa Makmur" },
    { arah: "Barat", berbatasan: "Hutan Lindung" },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Peta & Wilayah
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Peta Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Informasi wilayah administratif dan potensi desa
          </p>
        </div>
      </section>

      {/* Informasi Wilayah */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          {/* Batas Wilayah */}
          <Card className="mb-8">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <MapPin className="w-6 h-6 text-primary" />
                Batas Wilayah
              </CardTitle>
              <CardDescription>Wilayah berbatasan dengan desa sekitar</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                {batasWilayah.map((batas, index) => (
                  <div key={index} className="p-4 rounded-lg bg-accent/50 border border-border">
                    <p className="text-sm text-muted-foreground mb-1">{batas.arah}</p>
                    <p className="font-semibold">{batas.berbatasan}</p>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Pembagian Wilayah */}
          <div className="mb-12">
            <h2 className="text-2xl font-bold mb-6">Pembagian Wilayah Administratif</h2>
            <div className="grid md:grid-cols-2 gap-6">
              {wilayahData.map((wilayah, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardHeader>
                    <CardTitle className="text-xl">{wilayah.dusun}</CardTitle>
                    <CardDescription>Luas wilayah: {wilayah.luas}</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="grid grid-cols-3 gap-4">
                      <div className="text-center p-3 rounded-lg bg-accent/50">
                        <p className="text-2xl font-bold text-primary">{wilayah.rt}</p>
                        <p className="text-xs text-muted-foreground">RT</p>
                      </div>
                      <div className="text-center p-3 rounded-lg bg-accent/50">
                        <p className="text-2xl font-bold text-primary">{wilayah.rw}</p>
                        <p className="text-xs text-muted-foreground">RW</p>
                      </div>
                      <div className="text-center p-3 rounded-lg bg-accent/50">
                        <p className="text-2xl font-bold text-primary">{wilayah.kepalaKeluarga}</p>
                        <p className="text-xs text-muted-foreground">KK</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>

          {/* Potensi Desa */}
          <div>
            <h2 className="text-2xl font-bold mb-6">Potensi Desa</h2>
            <div className="space-y-6">
              {potensiData.map((potensi, index) => {
                const Icon = potensi.icon;
                return (
                  <Card key={index}>
                    <CardHeader>
                      <CardTitle className="flex items-center gap-2">
                        <Icon className={`w-6 h-6 ${potensi.color}`} />
                        {potensi.kategori}
                      </CardTitle>
                    </CardHeader>
                    <CardContent>
                      <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {potensi.items.map((item, idx) => (
                          <div key={idx} className="p-4 rounded-lg border border-border hover:border-primary/50 transition-colors">
                            <h4 className="font-semibold mb-2">{item.nama}</h4>
                            <div className="space-y-1 text-sm text-muted-foreground">
                              <p>{item.luas || item.jumlah}</p>
                              <p className="flex items-start gap-1">
                                <MapPin className="w-3 h-3 mt-0.5 flex-shrink-0" />
                                {item.lokasi}
                              </p>
                            </div>
                          </div>
                        ))}
                      </div>
                    </CardContent>
                  </Card>
                );
              })}
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default PetaDesa;
