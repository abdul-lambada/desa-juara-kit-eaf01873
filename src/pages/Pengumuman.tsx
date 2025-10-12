import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Megaphone, AlertCircle, Info, Calendar, MapPin } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Pengumuman = () => {
  const pengumumanData = [
    {
      id: 1,
      judul: "Pemadaman Listrik Terjadwal",
      kategori: "Penting",
      prioritas: "tinggi",
      tanggal: "2025-10-15",
      waktu: "08:00 - 12:00 WIB",
      lokasi: "Dusun 1 & 2",
      isi: "Akan dilakukan pemadaman listrik untuk perbaikan jaringan. Harap persiapkan kebutuhan listrik Anda.",
      icon: AlertCircle,
    },
    {
      id: 2,
      judul: "Pembagian Bantuan Sosial (Bansos)",
      kategori: "Sosial",
      prioritas: "sedang",
      tanggal: "2025-10-18",
      waktu: "09:00 - 15:00 WIB",
      lokasi: "Balai Desa",
      isi: "Pengambilan Bansos bulan Oktober. Harap membawa KTP dan KK asli. Warga yang berhak menerima sudah tercantum dalam daftar penerima.",
      icon: Megaphone,
    },
    {
      id: 3,
      judul: "Gotong Royong Bersih Desa",
      kategori: "Kegiatan",
      prioritas: "sedang",
      tanggal: "2025-10-20",
      waktu: "06:00 - 10:00 WIB",
      lokasi: "Seluruh Wilayah Desa",
      isi: "Ajakan untuk seluruh warga berpartisipasi dalam kegiatan bersih-bersih lingkungan desa. Mohon membawa peralatan kebersihan masing-masing.",
      icon: Info,
    },
    {
      id: 4,
      judul: "Musyawarah Rencana Pembangunan (Musrenbang)",
      kategori: "Penting",
      prioritas: "tinggi",
      tanggal: "2025-10-22",
      waktu: "13:00 - 16:00 WIB",
      lokasi: "Balai Desa",
      isi: "Undangan kepada tokoh masyarakat dan perwakilan RT/RW untuk menghadiri Musrenbang tahun 2026. Kehadiran sangat diharapkan.",
      icon: AlertCircle,
    },
    {
      id: 5,
      judul: "Pelayanan Administrasi Libur",
      kategori: "Informasi",
      prioritas: "rendah",
      tanggal: "2025-10-25",
      waktu: "Sepanjang Hari",
      lokasi: "Kantor Desa",
      isi: "Pelayanan administrasi desa libur dalam rangka peringatan hari besar nasional. Pelayanan akan kembali normal pada hari berikutnya.",
      icon: Info,
    },
    {
      id: 6,
      judul: "Vaksinasi Anak Balita",
      kategori: "Kesehatan",
      prioritas: "sedang",
      tanggal: "2025-10-28",
      waktu: "08:00 - 14:00 WIB",
      lokasi: "Posyandu Desa",
      isi: "Pelaksanaan vaksinasi rutin untuk anak balita. Harap membawa Buku KIA dan KMS. Gratis untuk seluruh warga.",
      icon: Megaphone,
    },
  ];

  const getPrioritasColor = (prioritas: string) => {
    switch (prioritas) {
      case "tinggi":
        return "destructive";
      case "sedang":
        return "default";
      default:
        return "secondary";
    }
  };

  const getPrioritasLabel = (prioritas: string) => {
    switch (prioritas) {
      case "tinggi":
        return "Prioritas Tinggi";
      case "sedang":
        return "Prioritas Sedang";
      default:
        return "Informasi";
    }
  };

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
            Pengumuman Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Informasi penting dan pengumuman terbaru untuk warga desa
          </p>
        </div>
      </section>

      {/* Filter Kategori */}
      <section className="py-8 border-b border-border">
        <div className="container mx-auto px-4">
          <div className="flex flex-wrap gap-2 justify-center">
            <Badge variant="default" className="cursor-pointer">Semua</Badge>
            <Badge variant="outline" className="cursor-pointer">Penting</Badge>
            <Badge variant="outline" className="cursor-pointer">Sosial</Badge>
            <Badge variant="outline" className="cursor-pointer">Kegiatan</Badge>
            <Badge variant="outline" className="cursor-pointer">Kesehatan</Badge>
            <Badge variant="outline" className="cursor-pointer">Informasi</Badge>
          </div>
        </div>
      </section>

      {/* Daftar Pengumuman */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="space-y-6">
            {pengumumanData.map((pengumuman) => {
              const Icon = pengumuman.icon;
              return (
                <Card key={pengumuman.id} className="hover:shadow-lg transition-shadow">
                  <CardHeader>
                    <div className="flex items-start justify-between gap-4 mb-2">
                      <div className="flex items-start gap-3 flex-1">
                        <div className="p-2 rounded-lg bg-primary/10">
                          <Icon className="w-6 h-6 text-primary" />
                        </div>
                        <div className="flex-1">
                          <div className="flex items-center gap-2 mb-2 flex-wrap">
                            <Badge variant="outline">{pengumuman.kategori}</Badge>
                            <Badge variant={getPrioritasColor(pengumuman.prioritas)}>
                              {getPrioritasLabel(pengumuman.prioritas)}
                            </Badge>
                          </div>
                          <CardTitle className="text-xl mb-2">{pengumuman.judul}</CardTitle>
                        </div>
                      </div>
                    </div>
                  </CardHeader>
                  <CardContent className="space-y-4">
                    <CardDescription className="text-base">{pengumuman.isi}</CardDescription>
                    
                    <div className="flex flex-wrap gap-4 pt-4 border-t border-border text-sm">
                      <div className="flex items-center gap-2 text-muted-foreground">
                        <Calendar className="w-4 h-4 text-primary" />
                        <span className="font-medium">{pengumuman.tanggal}</span>
                        <span>•</span>
                        <span>{pengumuman.waktu}</span>
                      </div>
                      <div className="flex items-center gap-2 text-muted-foreground">
                        <MapPin className="w-4 h-4 text-primary" />
                        <span>{pengumuman.lokasi}</span>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              );
            })}
          </div>
        </div>
      </section>

      {/* Info Banner */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <Card className="bg-gradient-hero text-primary-foreground">
            <CardContent className="p-8 md:p-12 text-center">
              <Megaphone className="w-12 h-12 mx-auto mb-4" />
              <h2 className="text-3xl font-bold mb-4">
                Punya Informasi Penting?
              </h2>
              <p className="text-lg opacity-90 mb-6 max-w-2xl mx-auto">
                Hubungi perangkat desa untuk menyampaikan informasi yang perlu diumumkan kepada warga
              </p>
            </CardContent>
          </Card>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Pengumuman;
