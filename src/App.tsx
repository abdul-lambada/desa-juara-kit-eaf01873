import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import Profil from "./pages/Profil";
import Berita from "./pages/Berita";
import Galeri from "./pages/Galeri";
import Kontak from "./pages/Kontak";
import Layanan from "./pages/Layanan";
import Produk from "./pages/Produk";
import Transparansi from "./pages/Transparansi";
import Statistik from "./pages/Statistik";
import PetaDesa from "./pages/PetaDesa";
import Pengumuman from "./pages/Pengumuman";
import Agenda from "./pages/Agenda";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/profil" element={<Profil />} />
          <Route path="/berita" element={<Berita />} />
          <Route path="/galeri" element={<Galeri />} />
          <Route path="/layanan" element={<Layanan />} />
          <Route path="/produk" element={<Produk />} />
          <Route path="/transparansi" element={<Transparansi />} />
          <Route path="/statistik" element={<Statistik />} />
          <Route path="/peta-desa" element={<PetaDesa />} />
          <Route path="/pengumuman" element={<Pengumuman />} />
          <Route path="/agenda" element={<Agenda />} />
          <Route path="/kontak" element={<Kontak />} />
          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
