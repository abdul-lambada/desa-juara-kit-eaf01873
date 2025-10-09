import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { MapPin, Phone, Mail, Clock, Facebook, Instagram, Twitter } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import { toast } from "sonner";
import { useState } from "react";

const Kontak = () => {
  const [formData, setFormData] = useState({
    nama: "",
    email: "",
    subjek: "",
    pesan: "",
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    toast.success("Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.");
    setFormData({ nama: "", email: "", subjek: "", pesan: "" });
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const contactInfo = [
    {
      icon: MapPin,
      title: "Alamat",
      content: "Jl. Raya Desa No. 123, Kec. Maju, Kab. Sejahtera, Provinsi Indonesia",
    },
    {
      icon: Phone,
      title: "Telepon",
      content: "(0274) 123-4567",
    },
    {
      icon: Mail,
      title: "Email",
      content: "info@desamajusejahtera.id",
    },
    {
      icon: Clock,
      title: "Jam Pelayanan",
      content: "Senin - Jumat: 08.00 - 16.00 WIB",
    },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Hubungi Kami
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Kontak Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Hubungi kami untuk informasi lebih lanjut atau sampaikan pertanyaan Anda
          </p>
        </div>
      </section>

      {/* Contact Info Cards */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            {contactInfo.map((info, index) => (
              <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                <CardContent className="pt-6">
                  <div className="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <info.icon className="w-6 h-6 text-primary" />
                  </div>
                  <h3 className="font-semibold text-foreground mb-2">{info.title}</h3>
                  <p className="text-sm text-muted-foreground">{info.content}</p>
                </CardContent>
              </Card>
            ))}
          </div>

          {/* Contact Form & Map */}
          <div className="grid lg:grid-cols-2 gap-8">
            {/* Form */}
            <Card className="hover:shadow-lg transition-shadow">
              <CardHeader>
                <CardTitle className="text-2xl">Kirim Pesan</CardTitle>
                <CardDescription>
                  Isi formulir di bawah ini untuk menghubungi kami
                </CardDescription>
              </CardHeader>
              <CardContent>
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="nama">Nama Lengkap</Label>
                    <Input
                      id="nama"
                      name="nama"
                      placeholder="Masukkan nama lengkap Anda"
                      value={formData.nama}
                      onChange={handleChange}
                      required
                    />
                  </div>
                  
                  <div className="space-y-2">
                    <Label htmlFor="email">Email</Label>
                    <Input
                      id="email"
                      name="email"
                      type="email"
                      placeholder="nama@email.com"
                      value={formData.email}
                      onChange={handleChange}
                      required
                    />
                  </div>
                  
                  <div className="space-y-2">
                    <Label htmlFor="subjek">Subjek</Label>
                    <Input
                      id="subjek"
                      name="subjek"
                      placeholder="Topik pesan Anda"
                      value={formData.subjek}
                      onChange={handleChange}
                      required
                    />
                  </div>
                  
                  <div className="space-y-2">
                    <Label htmlFor="pesan">Pesan</Label>
                    <Textarea
                      id="pesan"
                      name="pesan"
                      placeholder="Tulis pesan Anda di sini..."
                      rows={5}
                      value={formData.pesan}
                      onChange={handleChange}
                      required
                    />
                  </div>
                  
                  <Button type="submit" className="w-full font-semibold">
                    Kirim Pesan
                  </Button>
                </form>
              </CardContent>
            </Card>

            {/* Map & Additional Info */}
            <div className="space-y-6">
              <Card className="overflow-hidden">
                <div className="w-full h-64 bg-muted flex items-center justify-center">
                  <MapPin className="w-12 h-12 text-muted-foreground" />
                </div>
                <CardContent className="p-6">
                  <h3 className="font-semibold text-lg mb-2">Lokasi Kantor Desa</h3>
                  <p className="text-sm text-muted-foreground">
                    Kantor Desa Maju Sejahtera terletak di pusat desa, mudah diakses 
                    dari jalan raya utama. Tersedia area parkir yang luas.
                  </p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader>
                  <CardTitle>Media Sosial</CardTitle>
                  <CardDescription>
                    Ikuti kami di media sosial untuk update terbaru
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="flex gap-4">
                    <a
                      href="#"
                      className="flex items-center justify-center w-12 h-12 bg-primary/10 rounded-full hover:bg-primary hover:text-primary-foreground transition-colors"
                    >
                      <Facebook className="w-5 h-5" />
                    </a>
                    <a
                      href="#"
                      className="flex items-center justify-center w-12 h-12 bg-primary/10 rounded-full hover:bg-primary hover:text-primary-foreground transition-colors"
                    >
                      <Instagram className="w-5 h-5" />
                    </a>
                    <a
                      href="#"
                      className="flex items-center justify-center w-12 h-12 bg-primary/10 rounded-full hover:bg-primary hover:text-primary-foreground transition-colors"
                    >
                      <Twitter className="w-5 h-5" />
                    </a>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Kontak;
