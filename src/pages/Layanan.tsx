import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { FileText, UserCheck, Home, Baby, Heart, Briefcase, FileCheck, Download } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import { Link } from "react-router-dom";

const Layanan = () => {
  const layananSurat = [
    {
      icon: FileText,
      title: "Surat Keterangan Domisili",
      description: "Pembuatan surat keterangan domisili untuk warga",
      persyaratan: ["KTP Asli", "KK Asli", "Foto 3x4 (2 lembar)"],
      waktu: "1-2 hari kerja",
    },
    {
      icon: UserCheck,
      title: "Surat Keterangan Usaha",
      description: "Surat keterangan untuk pelaku usaha dan UMKM",
      persyaratan: ["KTP Asli", "KK Asli", "Foto usaha", "Surat pernyataan"],
      waktu: "2-3 hari kerja",
    },
    {
      icon: Home,
      title: "Surat Pengantar KTP",
      description: "Surat pengantar untuk pembuatan KTP baru",
      persyaratan: ["KK Asli", "Akta Kelahiran", "Foto 3x4 (4 lembar)"],
      waktu: "1 hari kerja",
    },
    {
      icon: Baby,
      title: "Surat Keterangan Kelahiran",
      description: "Surat keterangan untuk pendaftaran kelahiran bayi",
      persyaratan: ["KTP Orang Tua", "KK Asli", "Surat Keterangan dari Bidan/RS"],
      waktu: "1 hari kerja",
    },
    {
      icon: Heart,
      title: "Surat Pengantar Nikah",
      description: "Surat pengantar untuk pendaftaran pernikahan",
      persyaratan: ["KTP Asli", "KK Asli", "Akta Kelahiran", "Foto 3x4 (4 lembar)"],
      waktu: "2-3 hari kerja",
    },
    {
      icon: Briefcase,
      title: "Surat Keterangan Tidak Mampu",
      description: "SKTM untuk keperluan beasiswa, bantuan, dll",
      persyaratan: ["KTP Asli", "KK Asli", "Surat Pernyataan"],
      waktu: "1-2 hari kerja",
    },
    {
      icon: FileCheck,
      title: "Surat Keterangan Pindah",
      description: "Surat untuk keperluan pindah domisili",
      persyaratan: ["KTP Asli", "KK Asli", "Surat Pengantar RT/RW"],
      waktu: "2-3 hari kerja",
    },
    {
      icon: Download,
      title: "Legalisir Dokumen",
      description: "Legalisir surat-surat keterangan desa",
      persyaratan: ["Dokumen yang akan dilegalisir", "KTP Asli"],
      waktu: "1 hari kerja",
    },
  ];

  const prosedur = [
    {
      step: "1",
      title: "Datang ke Kantor Desa",
      description: "Kunjungi kantor desa pada jam pelayanan",
    },
    {
      step: "2",
      title: "Siapkan Persyaratan",
      description: "Lengkapi dokumen yang diperlukan",
    },
    {
      step: "3",
      title: "Isi Formulir",
      description: "Isi formulir permohonan yang disediakan",
    },
    {
      step: "4",
      title: "Proses Verifikasi",
      description: "Petugas akan memverifikasi dokumen Anda",
    },
    {
      step: "5",
      title: "Ambil Surat",
      description: "Surat dapat diambil sesuai waktu yang ditentukan",
    },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Layanan Publik
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Layanan Administrasi Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Pelayanan administrasi kependudukan dan surat-menyurat untuk masyarakat
          </p>
        </div>
      </section>

      {/* Jam Layanan */}
      <section className="py-8 bg-primary/5">
        <div className="container mx-auto px-4">
          <div className="text-center">
            <p className="text-lg font-semibold text-foreground">
              Jam Pelayanan: <span className="text-primary">Senin - Jumat, 08.00 - 16.00 WIB</span>
            </p>
            <p className="text-sm text-muted-foreground mt-2">
              Istirahat: 12.00 - 13.00 WIB
            </p>
          </div>
        </div>
      </section>

      {/* Layanan Surat */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-foreground mb-4">
              Jenis Layanan Surat
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Berbagai jenis layanan administrasi yang dapat Anda ajukan di kantor desa
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {layananSurat.map((layanan, index) => (
              <Card key={index} className="hover:shadow-lg transition-shadow group">
                <CardHeader>
                  <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                    <layanan.icon className="w-6 h-6" />
                  </div>
                  <CardTitle className="text-lg">{layanan.title}</CardTitle>
                  <CardDescription>{layanan.description}</CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="space-y-3">
                    <div>
                      <p className="text-sm font-semibold text-foreground mb-2">Persyaratan:</p>
                      <ul className="text-sm text-muted-foreground space-y-1">
                        {layanan.persyaratan.map((item, idx) => (
                          <li key={idx} className="flex items-start">
                            <span className="mr-2">•</span>
                            <span>{item}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                    <div className="pt-2 border-t">
                      <p className="text-sm">
                        <span className="font-semibold text-foreground">Waktu: </span>
                        <span className="text-primary">{layanan.waktu}</span>
                      </p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Prosedur */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-foreground mb-4">
              Prosedur Pelayanan
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Langkah-langkah mudah untuk mendapatkan layanan administrasi
            </p>
          </div>

          <div className="max-w-4xl mx-auto">
            <div className="grid md:grid-cols-5 gap-6">
              {prosedur.map((item, index) => (
                <div key={index} className="text-center">
                  <div className="w-16 h-16 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    {item.step}
                  </div>
                  <h3 className="font-semibold text-foreground mb-2">{item.title}</h3>
                  <p className="text-sm text-muted-foreground">{item.description}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <Card className="bg-gradient-hero text-primary-foreground">
            <CardContent className="p-8 md:p-12 text-center">
              <h2 className="text-3xl font-bold mb-4">
                Butuh Bantuan Lebih Lanjut?
              </h2>
              <p className="text-lg opacity-90 mb-6 max-w-2xl mx-auto">
                Hubungi kami untuk informasi lebih detail tentang persyaratan dan prosedur layanan
              </p>
              <Link to="/kontak">
                <Button size="lg" variant="secondary" className="font-semibold">
                  Hubungi Kami
                </Button>
              </Link>
            </CardContent>
          </Card>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Layanan;
