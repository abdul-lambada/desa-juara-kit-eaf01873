import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Calendar, Clock, MapPin, Users, AlertCircle } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Agenda = () => {
  const agendaData = [
    {
      id: 1,
      judul: "Rapat Koordinasi RT/RW",
      tanggal: "2025-10-16",
      hari: "Kamis",
      waktu: "19:00 - 21:00 WIB",
      tempat: "Balai Desa",
      penyelenggara: "Pemerintah Desa",
      peserta: "Ketua RT/RW",
      deskripsi: "Koordinasi program kerja bulanan dan evaluasi kegiatan desa",
      kategori: "Rapat",
      status: "akan-datang",
    },
    {
      id: 2,
      judul: "Pelatihan UMKM Digital Marketing",
      tanggal: "2025-10-19",
      hari: "Minggu",
      waktu: "09:00 - 15:00 WIB",
      tempat: "Balai Desa",
      penyelenggara: "Dinas Koperasi & UMKM",
      peserta: "Pelaku UMKM Desa (50 orang)",
      deskripsi: "Pelatihan cara memasarkan produk UMKM melalui media sosial dan marketplace",
      kategori: "Pelatihan",
      status: "akan-datang",
    },
    {
      id: 3,
      judul: "Senam Sehat Bersama",
      tanggal: "2025-10-20",
      hari: "Senin",
      waktu: "06:00 - 07:30 WIB",
      tempat: "Lapangan Desa",
      penyelenggara: "PKK Desa",
      peserta: "Seluruh Warga",
      deskripsi: "Senam pagi rutin untuk menjaga kesehatan warga",
      kategori: "Olahraga",
      status: "akan-datang",
    },
    {
      id: 4,
      judul: "Posyandu Balita & Lansia",
      tanggal: "2025-10-21",
      hari: "Selasa",
      waktu: "08:00 - 12:00 WIB",
      tempat: "Posyandu Dusun 1-4",
      penyelenggara: "Kader Posyandu",
      peserta: "Balita, Ibu Hamil, Lansia",
      deskripsi: "Pemeriksaan kesehatan rutin, penimbangan, dan pemberian vitamin",
      kategori: "Kesehatan",
      status: "akan-datang",
    },
    {
      id: 5,
      judul: "Musyawarah Desa (Musdes)",
      tanggal: "2025-10-23",
      hari: "Kamis",
      waktu: "13:00 - 17:00 WIB",
      tempat: "Balai Desa",
      penyelenggara: "Pemerintah Desa",
      peserta: "BPD, Tokoh Masyarakat, RT/RW",
      deskripsi: "Pembahasan APBDes tahun 2026 dan program prioritas desa",
      kategori: "Rapat",
      status: "akan-datang",
    },
    {
      id: 6,
      judul: "Kerja Bakti Lingkungan",
      tanggal: "2025-10-27",
      hari: "Senin",
      waktu: "06:00 - 09:00 WIB",
      tempat: "Seluruh Wilayah Desa",
      penyelenggara: "Karang Taruna",
      peserta: "Seluruh Warga",
      deskripsi: "Gotong royong membersihkan jalan, selokan, dan fasilitas umum",
      kategori: "Sosial",
      status: "akan-datang",
    },
    {
      id: 7,
      judul: "Festival Budaya Desa",
      tanggal: "2025-11-05",
      hari: "Rabu",
      waktu: "08:00 - 17:00 WIB",
      tempat: "Lapangan Desa",
      penyelenggara: "Panitia Festival Desa",
      peserta: "Seluruh Warga & Undangan",
      deskripsi: "Perayaan HUT Desa dengan berbagai lomba, pameran UMKM, dan pertunjukan seni budaya",
      kategori: "Acara",
      status: "akan-datang",
    },
    {
      id: 8,
      judul: "Pelatihan Budidaya Jamur",
      tanggal: "2025-11-10",
      hari: "Senin",
      waktu: "09:00 - 14:00 WIB",
      tempat: "Balai Desa",
      penyelenggara: "Dinas Pertanian",
      peserta: "Kelompok Tani (30 orang)",
      deskripsi: "Pelatihan teknik budidaya jamur tiram untuk meningkatkan pendapatan petani",
      kategori: "Pelatihan",
      status: "akan-datang",
    },
  ];

  const kategoriColors: Record<string, string> = {
    "Rapat": "bg-blue-100 text-blue-700 border-blue-300",
    "Pelatihan": "bg-purple-100 text-purple-700 border-purple-300",
    "Olahraga": "bg-green-100 text-green-700 border-green-300",
    "Kesehatan": "bg-red-100 text-red-700 border-red-300",
    "Sosial": "bg-yellow-100 text-yellow-700 border-yellow-300",
    "Acara": "bg-pink-100 text-pink-700 border-pink-300",
  };

  // Group by month
  const groupedAgenda = agendaData.reduce((acc, agenda) => {
    const month = new Date(agenda.tanggal).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
    if (!acc[month]) {
      acc[month] = [];
    }
    acc[month].push(agenda);
    return acc;
  }, {} as Record<string, typeof agendaData>);

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Kalender Kegiatan
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Agenda Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Jadwal kegiatan dan acara yang akan dilaksanakan di desa
          </p>
        </div>
      </section>

      {/* Filter Kategori */}
      <section className="py-8 border-b border-border">
        <div className="container mx-auto px-4">
          <div className="flex flex-wrap gap-2 justify-center">
            <Badge variant="default" className="cursor-pointer">Semua</Badge>
            <Badge variant="outline" className="cursor-pointer">Rapat</Badge>
            <Badge variant="outline" className="cursor-pointer">Pelatihan</Badge>
            <Badge variant="outline" className="cursor-pointer">Olahraga</Badge>
            <Badge variant="outline" className="cursor-pointer">Kesehatan</Badge>
            <Badge variant="outline" className="cursor-pointer">Sosial</Badge>
            <Badge variant="outline" className="cursor-pointer">Acara</Badge>
          </div>
        </div>
      </section>

      {/* Agenda List */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          {Object.entries(groupedAgenda).map(([month, agendas]) => (
            <div key={month} className="mb-12">
              <h2 className="text-2xl font-bold mb-6 flex items-center gap-2">
                <Calendar className="w-6 h-6 text-primary" />
                {month}
              </h2>
              <div className="space-y-6">
                {agendas.map((agenda) => (
                  <Card key={agenda.id} className="hover:shadow-lg transition-shadow">
                    <CardHeader>
                      <div className="flex items-start justify-between gap-4 mb-2">
                        <div className="flex-1">
                          <div className="flex items-center gap-2 mb-3 flex-wrap">
                            <Badge 
                              className={kategoriColors[agenda.kategori] || ""}
                              variant="outline"
                            >
                              {agenda.kategori}
                            </Badge>
                            {agenda.status === "akan-datang" && (
                              <Badge variant="secondary">
                                <AlertCircle className="w-3 h-3 mr-1" />
                                Akan Datang
                              </Badge>
                            )}
                          </div>
                          <CardTitle className="text-2xl mb-2">{agenda.judul}</CardTitle>
                        </div>
                        <div className="text-right bg-primary/10 p-4 rounded-lg min-w-24">
                          <p className="text-3xl font-bold text-primary">
                            {new Date(agenda.tanggal).getDate()}
                          </p>
                          <p className="text-sm font-medium text-muted-foreground">
                            {agenda.hari}
                          </p>
                        </div>
                      </div>
                    </CardHeader>
                    <CardContent className="space-y-4">
                      <CardDescription className="text-base">{agenda.deskripsi}</CardDescription>
                      
                      <div className="grid md:grid-cols-2 gap-4 pt-4 border-t border-border">
                        <div className="space-y-3">
                          <div className="flex items-start gap-2">
                            <Clock className="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <div>
                              <p className="text-sm text-muted-foreground">Waktu</p>
                              <p className="font-medium">{agenda.waktu}</p>
                            </div>
                          </div>
                          <div className="flex items-start gap-2">
                            <MapPin className="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <div>
                              <p className="text-sm text-muted-foreground">Tempat</p>
                              <p className="font-medium">{agenda.tempat}</p>
                            </div>
                          </div>
                        </div>
                        <div className="space-y-3">
                          <div className="flex items-start gap-2">
                            <Users className="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <div>
                              <p className="text-sm text-muted-foreground">Penyelenggara</p>
                              <p className="font-medium">{agenda.penyelenggara}</p>
                            </div>
                          </div>
                          <div className="flex items-start gap-2">
                            <Users className="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <div>
                              <p className="text-sm text-muted-foreground">Peserta</p>
                              <p className="font-medium">{agenda.peserta}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Info Banner */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <Card className="bg-gradient-hero text-primary-foreground">
            <CardContent className="p-8 md:p-12 text-center">
              <Calendar className="w-12 h-12 mx-auto mb-4" />
              <h2 className="text-3xl font-bold mb-4">
                Ingin Mengadakan Kegiatan?
              </h2>
              <p className="text-lg opacity-90 mb-6 max-w-2xl mx-auto">
                Koordinasikan kegiatan Anda dengan perangkat desa agar dapat didaftarkan dalam agenda resmi desa
              </p>
            </CardContent>
          </Card>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Agenda;
