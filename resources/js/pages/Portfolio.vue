<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Accordion, AccordionItem, AccordionTrigger, AccordionContent } from '@/components/ui/accordion';
import { ref } from 'vue';


defineProps({
    profile: Object
});
</script>

<template>
  <Head title="Portfolio" />
  <div class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <Card>
      <CardHeader>
        <img :src="profile.image" alt="Profile Image" class="w-32 h-32 rounded-full mx-auto" />
        <CardTitle class="text-center mt-4 text-2xl">{{ profile.name }}</CardTitle>
      </CardHeader>
      <CardContent>
        <p class="text-center">{{ profile.objective }}</p>
      </CardContent>
    </Card>
    <Card>
      <CardHeader>
        <CardTitle>Contact Information</CardTitle>
      </CardHeader>
      <CardContent>
        <Table>
          <TableBody>
            <TableRow v-for="contact in profile.contact" :key="contact.label">
              <TableHead>{{ contact.label }}</TableHead>
              <TableCell class="text-right">{{ contact.value }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </CardContent>
    </Card>
    <Card>
      <CardHeader>
        <CardTitle>Academic Background</CardTitle>
      </CardHeader>
      <CardContent>
        <Table>
          <TableBody>
            <TableRow v-for="edu in profile.academics" :key="edu.degree">
              <TableCell>{{ edu.degree }}</TableCell>
              <TableCell>{{ edu.year }}</TableCell>
              <TableCell>{{ edu.institute }}</TableCell>
              <TableCell class="text-right">{{ edu.gpa }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </CardContent>
    </Card>
    <Card>
      <CardHeader>
        <CardTitle>Technical Skills</CardTitle>
      </CardHeader>
      <CardContent>
        <ul class="list-disc ml-5">
          <li v-for="skill in profile.skills" :key="skill.category">
            <strong>{{ skill.category }}:</strong> {{ skill.details }}
          </li>
        </ul>
      </CardContent>
    </Card>
    <Card>
      <CardHeader>
        <CardTitle>Work Experience</CardTitle>
      </CardHeader>
      <CardContent>
        <ul class="list-disc ml-5">
          <li v-for="exp in profile.experience" :key="exp.company">
            <strong>{{ exp.position }}</strong> at {{ exp.company }} ({{ exp.duration }})
          </li>
        </ul>
      </CardContent>
    </Card>
    <Card>
      <CardHeader>
        <CardTitle>Hobbies & Interests</CardTitle>
      </CardHeader>
      <CardContent>
        <Accordion type="single" collapsible>
          <AccordionItem v-for="hobby in profile.hobbies" :key="hobby.title" :value="hobby.title">
            <AccordionTrigger>{{ hobby.title }}</AccordionTrigger>
            <AccordionContent>{{ hobby.description }}</AccordionContent>
          </AccordionItem>
        </Accordion>
      </CardContent>
    </Card>
  </div>

  
</template>

